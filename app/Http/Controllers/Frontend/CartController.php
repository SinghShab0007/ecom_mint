<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\CartItem;
use App\Models\Frontend\Product;
use App\Models\Productstock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $quantity = (int) $request->get('qty', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $product = Product::with('details')->findOrFail($request->get('id'));

        $hasVariantRows = Productstock::where('product_id', $product->id)->exists();

        if ($hasVariantRows) {
            $anySize = Productstock::where('product_id', $product->id)->whereNotNull('size_id')->exists();
            $anyColor = Productstock::where('product_id', $product->id)->whereNotNull('color_id')->exists();

            if (! $anySize && ! $anyColor) {
                /** Rows exist (e.g. legacy rows) but no size/color — inventory is product-level only. */
                if ($product->is_manage_stock && $quantity > $product->quantity) {
                    return response()->json([
                        'status' => 'error',
                        'message' => __('Out of stock product. Available quantity is :qty.', ['qty' => $product->quantity]),
                    ], 422);
                }
            } else {
                $sizeId = $request->input('size_id');
                $colorId = $request->input('color_id');

                if ($anySize && ($sizeId === null || $sizeId === '')) {
                    return response()->json([
                        'status' => 'error',
                        'message' => __('Please select a size.'),
                    ], 422);
                }

                if ($anyColor && ($colorId === null || $colorId === '')) {
                    return response()->json([
                        'status' => 'error',
                        'message' => __('Please select a color.'),
                    ], 422);
                }

                $stockQuery = Productstock::where('product_id', $product->id);
                if ($anySize) {
                    $stockQuery->where('size_id', $sizeId);
                }
                if ($anyColor) {
                    $stockQuery->where('color_id', $colorId);
                }

                $product_stock = $stockQuery->first();

                if (! $product_stock) {
                    return response()->json([
                        'status' => 'error',
                        'message' => __('This variant is out of stock. Please select another variant.'),
                    ], 422);
                }

                $variantQty = (int) ($product_stock->quantities ?? 0);
                if ($variantQty < 1 || $quantity > $variantQty) {
                    return response()->json([
                        'status' => 'error',
                        'message' => __('This variant is out of stock. Please select another variant.'),
                    ], 422);
                }
            }
        } elseif ($product->is_manage_stock && $quantity > $product->quantity) {
            return response()->json([
                'status' => 'error',
                'message' => __('Out of stock product. Available quantity is :qty.', ['qty' => $product->quantity]),
            ], 422);
        }

        $cart = json_decode(Cookie::get('cart', ''), true) ?? [];
        $uniqid = (string) $request->get('id');
        if ($request->filled('color_id') || $request->filled('size_id')) {
            $uniqid .= '-' . $request->get('color_id') . '-' . $request->get('size_id');
        } elseif ($request->color || $request->size) {
            $uniqid .= '-' . $request->color . '-' . $request->size;
        }

        $cart_collection = collect($cart);
        $is_common_seller = $cart_collection->contains('seller_id', $product->seller_id);

        $totalShipping = (float) (Cookie::get('totalShipping') ?? 0);
        if (!$is_common_seller) {
            $totalShipping += (float) ($request->shipping_area == 'inside' ? $product->shipping_cost : $product->outside_shipping_cost);
        }

        $vatRate = $product->details ? ($product->details->vat ?? 0) : 0;
        if (isset($cart[$uniqid]['id']) && $cart[$uniqid]['id'] == $product->id) {
            $total_price = CartItem::price($product->id, $cart[$uniqid]['quantity'] + $quantity);
            $cart[$uniqid] = [
                'id' => $product->id,
                'discount' => $product->discount,
                'vat' => ($total_price / 100) * $vatRate,
                'quantity' => $cart[$uniqid]['quantity'] + $quantity,
                'currency_id' => userCurrency('id'),
                'courier' => $request->get('courier'),
                'color' => $request->get('color'),
                'color_id' => $request->get('color_id'),
                'size' => $request->get('size'),
                'size_id' => $request->get('size_id'),
                'seller_id' => $product->seller_id,
                'shipping_area' => $request->shipping_area,
                'total' => CartItem::shipping($product->id, $cart[$uniqid]['quantity'] + $quantity) + $total_price,
                'product_stock'=> $product->quantity
            ];
        } else {
            $total_price = CartItem::price($product->id, $quantity);
            $cart[$uniqid] = [
                'id' => $product->id,
                'quantity' => $quantity,
                'vat' => ($total_price / 100) * $vatRate,
                'discount' => $product->discount,
                'currency_id' => userCurrency('id'),
                'courier' => $request->get('courier'),
                'color' => $request->get('color'),
                'color_id' => $request->get('color_id'),
                'size' => $request->get('size'),
                'size_id' => $request->get('size_id'),
                'seller_id' => $product->seller_id,

                'shipping_area' => $request->shipping_area,
                'total' => CartItem::shipping($product->id, $quantity) + $total_price,
                'product_stock'=> $product->quantity
            ];
        }

        Cookie::queue(Cookie::make('cart', json_encode($cart), 120));

        $subTotal = 0;
        $total_vat = 0;
        $total_discount = 0;
        foreach ($cart as $item) {
            $total_vat += $item['vat'] ?? 0;
            $total_discount += $item['discount'] ?? 0;
            $subTotal += CartItem::price($item['id'], $item['quantity']);
        }

        $total = $subTotal + $totalShipping;

        Cookie::queue(Cookie::make('total', $total));
        Cookie::queue(Cookie::make('subTotal', $subTotal));
        Cookie::queue(Cookie::make('total_vat', $total_vat));
        Cookie::queue(Cookie::make('total_discount', $total_discount));
        Cookie::queue(Cookie::make('totalShipping', $totalShipping));

        $count = count($cart); //count cart items

        return response(['status' => 'success', 'count' => $count, 'name' => $product->name]);
    }

    public function updateCart(Request $request)
    {
        $key = $request->get('key');
        $id = $request->get('id');
        $product = Product::with('details')->findOrFail($id);
        $cart = json_decode(Cookie::get('cart', ''), true) ?? [];
        $total_price = CartItem::price($id, $request->get('qty'));

        if ($product->is_manage_stock && $request->get('qty') > $product->quantity) {
            return response()->json($request->get('qty'). __(' quantities is not available.'));
        }

        $vatRate = $product->details ? ($product->details->vat ?? 0) : 0;
        $cart[$key] = [
            'id' => $id,
            'quantity' => $request->get('qty'),
            'vat' => ($total_price / 100) * $vatRate,
            'currency_id' => userCurrency('id'),
            'discount' => $product->discount,
            'size' => $cart[$key]['size'] ?? NULL,
            'color' => $cart[$key]['color'] ?? NULL,
            'size_id' => $cart[$key]['size_id'] ?? NULL,
            'courier' => $cart[$key]['courier'] ?? NULL,
            'color_id' => $cart[$key]['color_id'] ?? NULL,
            // Carry these over: rebuilding the row without them left the item
            // with no shipping_area/seller_id, which made removeFromCart fatal
            // and threw off the per-seller shipping total.
            'shipping_area' => $cart[$key]['shipping_area'] ?? NULL,
            'seller_id' => $cart[$key]['seller_id'] ?? $product->seller_id,
            'total' => CartItem::shipping($id, $request->get('qty')) + $total_price,
            'product_stock'=> $product->quantity
        ];

        Cookie::queue(Cookie::make('cart', json_encode($cart), 120));

        $subTotal = 0;
        $totalShipping = (float) (Cookie::get('totalShipping') ?? 0);
        foreach ($cart as $item) {
            $subTotal += CartItem::price($item['id'], $item['quantity']);
        }

        $productTotal = CartItem::price($id, $request->get('qty'));
        $total = $subTotal + $totalShipping;

        Cookie::queue(Cookie::make('subTotal', $subTotal, 120));
        Cookie::queue(Cookie::make('totalShipping', $totalShipping, 120));
        Cookie::queue(Cookie::make('total', $total, 120));

        return response([
            'status' => 'success',
            'sub_total' => currency($subTotal, 2),
            'productTotal' => currency($productTotal, 2),
            'grand_total' => currency($subTotal + $totalShipping, 2),
        ]);
    }

    /**
     * Remove item form cart by ajax
     *
     * @param Request $request
     * @return Response
     */
    public function removeFromCart(Request $request)
    {
        $key = $request->get('key');
        $id = $request->get('id');

        $cart = json_decode(Cookie::get('cart', ''), true) ?? [];
        $remove_item = $cart[$key] ?? null;
        if ($remove_item === null) {
            return response()->json(['status' => 'error', 'message' => __('Item not found in cart.')], 404);
        }
        unset($cart[$key]);
        if (empty($cart)) {
            Cookie::queue(Cookie::forget('cart'));
        } else {
            Cookie::queue(Cookie::make('cart', json_encode($cart), 120));
        }

        $count = count($cart);
        $product = Product::query()->findOrFail($id);

        $cart_collection = collect($cart);
        $is_common_seller = $cart_collection->contains('seller_id', $product->seller_id);

        $totalShipping = (float) (Cookie::get('totalShipping') ?? 0);
        if (!$is_common_seller) {
            $shippingArea = $remove_item['shipping_area'] ?? 'inside';
            $totalShipping -= (float) ($shippingArea === 'inside' ? $product->shipping_cost : $product->outside_shipping_cost);
        }

        $subTotal = 0;
        foreach ($cart as $item) {
            $subTotal += CartItem::price($item['id'], $item['quantity']);
        }

        Cookie::queue(Cookie::make('total', $subTotal, 120));
        Cookie::queue(Cookie::make('subTotal', $subTotal, 120));
        Cookie::queue(Cookie::make('totalShipping', max(0, $totalShipping)));

        return response([
            'status' => 'success',
            'count' => $count,
            'sub_total' => currency($subTotal, 2),
            'grand_total' => currency($subTotal, 2),
            'totalShipping' => currency($totalShipping, 2),
        ]);
    }
}
