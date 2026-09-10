<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Backend\Product;
use App\Models\Frontend\Coupon;
use App\Models\Frontend\CouponUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function index(Request $request)
    {
        $code = $request->get('code');
        $coupon = Coupon::query()->where('code', $code)->first();

        if (!$coupon) {
            return response(['status' => 'error', 'discount' => 0, 'msg' => 'Coupon not found.']);
        }

        $total_usage = CouponUsage::query()->where('coupon_id', $coupon->id)->count();
        $exists = CouponUsage::query()->where('coupon_id', $coupon->id)->where('user_id', auth('customer')->id())->exists();
        if(!$coupon){
            return response(['status'=>'error','discount'=>0,'msg'=>'Coupon not found.']);
        }elseif($coupon->end < now()->format('Y-m-d')){
            return response(['status'=>'error','discount'=>0,'msg'=>'Coupon has been expired.']);
        }elseif($coupon->start > now()){
            return response(['status'=>'error','discount'=>0,'msg'=>'Coupon is not eligible now.']);
        }elseif($coupon->qty <= $total_usage){
            return response(['status'=>'error','discount'=>0,'msg'=>'Coupon exceeded usage limit.']);
        }elseif($exists){
            return response(['status'=>'error','discount'=>0,'msg'=>'You have already used this coupon.']);
        }

        $subTotal = Cookie::get('subTotal');
        $totalShipping = Cookie::get('totalShipping');
        $discount = $coupon->discount;

        if ($coupon->type == 'cart') {
            $details = json_decode($coupon->details);

            $subTotal = Cookie::get('subTotal');
            $totalShipping = Cookie::get('totalShipping');

            if ($coupon->discount_type == 'percent') {
                $discount = $subTotal * ($discount / 100);
            }
        } else {
            $cart = json_decode(Cookie::get('cart'), true);
            $couponProductId = json_decode($coupon->details)->product_id;

            $eligible = false;
            $discount = 0;
            foreach ($couponProductId as $id) {
                //$exists = array_search($id, array_column($cart, 'id'));
                $arrayExist =   array_filter($cart,function ($row) use($id){
                    return $row['id']==$id;
                });
                $arrayExistRest = reset($arrayExist);
                if ($arrayExistRest) {
                    $eligible = true;
                    //$productIndex = $exists;
                    $product = Product::query()->findOrFail($id);
                    $quantity = $arrayExistRest['quantity'];

                    if ($coupon->discount_type == 'percent') {
                        $discount += ($product->sale_price *$quantity) * ($coupon->discount / 100) ;
                    }

                    // You can use $quantity as the quantity of the product with the given ID
                }
            }

            if ($eligible) {
                $discount = 0;
            }
        }
        $total = (floatval($subTotal) + floatval($totalShipping)) - $discount;

        Cookie::queue(Cookie::make('coupon_infos', $coupon, 120));
        Cookie::queue(Cookie::make('coupon_id', $coupon->id, 120));
        Cookie::queue(Cookie::make('coupon_discount', $discount, 120));

        return response()->json([
            'message' => __('The coupon has been applied'),
            'coupon_infos' => view('customer.checkout._coupon-infos', compact('coupon'))->render(),
            'after_coupon' => view('customer.checkout._order-details', compact('subTotal', 'totalShipping', 'discount', 'total'))->render(),
        ]);
    }

    public function remove()
    {
        Cookie::queue(Cookie::forget('coupon_id'));
        Cookie::queue(Cookie::forget('coupon_infos'));
        Cookie::queue(Cookie::forget('coupon_discount'));

        $subTotal = Cookie::get('subTotal');
        $totalShipping = Cookie::get('totalShipping');
        $total = floatval($subTotal) + floatval($totalShipping);

        return response()->json([
            'message' => __('Coupon has been removed'),
            'data' => view('customer.checkout._order-details', compact('subTotal', 'totalShipping', 'total'))->render()
        ]);
    }

    public function buyNowCoupon(Request $request, $id)
    {
        $code = $request->get('code');
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response(['status' => 'error', 'discount' => 0, 'msg' => 'Coupon not found.']);
        }

        $product = Product::query()->find($id);
        $total_usage = CouponUsage::where('coupon_id', $coupon->id)->count();
        $exists = CouponUsage::where('coupon_id', $coupon->id)->where('user_id', auth('customer')->id())->exists();

        if ($coupon->end < now()) {
            return response(['status' => 'error', 'discount' => 0, 'msg' => 'Coupon has been expired.']);
        } elseif ($coupon->start > now()) {
            return response(['status' => 'error', 'discount' => 0, 'msg' => 'Coupon is not eligible now.']);
        } elseif ($coupon->qty <= $total_usage) {
            return response(['status' => 'error', 'discount' => 0, 'msg' => 'Coupon exceeded usage limit.']);
        } elseif ($exists) {
            return response(['status' => 'error', 'discount' => 0, 'msg' => 'You have already used this coupon.']);
        } elseif (!$product) {
            return response(['status' => 'error', 'discount' => 0, 'msg' => 'Product not found.']);
        }

        $shipping_cost = session('area') == 'inside' ? $product->shipping_cost : $product->outside_shipping_cost;
        $subTotal = $product->sale_price * session('qty');
        $discount = $coupon->discount;

        if ($coupon->type == 'cart') {
            if ($coupon->discount_type == 'percent') {
                $discount = $subTotal * ($discount / 100);
            }
        } else {
            $price = $product->sale_price;
            if ($coupon->discount_type == 'percent') {
                $discount = $price * ($discount / 100);
            }
        }

        $total = (floatval($subTotal) + floatval($shipping_cost)) - $discount;

        Cookie::queue(Cookie::make('coupon_infos', $coupon, 120));
        Cookie::queue(Cookie::make('coupon_id', $coupon->id, 120));
        Cookie::queue(Cookie::make('coupon_discount', $discount, 120));

        return response()->json([
            'message' => __('The coupon has been applied'),
            'coupon_infos' => view('customer.checkout._coupon-infos', compact('coupon'))->render(),
            'after_coupon' => view('customer.checkout._order-details', compact('subTotal', 'totalShipping', 'discount', 'total'))->render(),
        ]);
    }
}
