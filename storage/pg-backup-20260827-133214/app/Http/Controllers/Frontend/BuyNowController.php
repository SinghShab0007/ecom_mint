<?php

namespace App\Http\Controllers\Frontend;

use App\Mail\OrderPending;
use App\Models\Frontend\CouponUsage;
use App\Models\Productstock;
use Illuminate\Http\Request;
use App\Helpers\NotifyHelper;
use App\Models\Frontend\Order;
use App\Models\Frontend\Product;
use App\Http\Controllers\Controller;
use App\Models\Frontend\OrderDetail;
use App\Models\Frontend\UserBilling;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use App\Models\Frontend\OrderTimeline;
use Illuminate\Support\Facades\Session;
use App\Models\Frontend\PaymentGateway;
use App\Models\Frontend\ShippingAddress;

class BuyNowController extends Controller
{
    use NotifyHelper;

    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function index(Request $request)
    {
        abort_if(!$request->qty, 404);
        $product = Product::with('images')->findOrFail($request->product_id);
        session()->put('qty', $request->qty);
        session()->put('area', $request->area);
        session()->put('variation', [
            'size' => $request->size,
            'color' => $request->color,
            'size_id' => $this->normalizeVariationId($request->size_id),
            'color_id' => $this->normalizeVariationId($request->color_id),
        ]);
        $billing = UserBilling::query()
            ->where('user_id', auth('customer')->id())
            ->where('is_active', 1)
            ->first();

        $shipping = ShippingAddress::query()
            ->where('user_id', auth('customer')->id())
            ->latest()
            ->first();
        $subTotal = $request->qty * $product->sale_price;
        $totalShipping = $request->area == 'inside' ? $product->shipping_cost : $product->outside_shipping_cost;
        $total = $subTotal + $totalShipping;
        Cookie::queue(Cookie::make('subTotal', $subTotal,120));
        Cookie::queue(Cookie::make('totalShipping', $totalShipping,120));
        Cookie::queue(Cookie::make('total', $total,120));

        $paysantsPayEnabled = PaymentGateway::query()
            ->where('name', 'PaysantsPay')
            ->where('status', 1)
            ->exists();

        return view('customer.buynow.checkout', compact('product', 'billing', 'shipping', 'paysantsPayEnabled'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:100',
            'product_id' => 'required|integer',
            'mobile' => 'required|string|max:15',
            'shipping_address' => 'required|string|max:250',
            'billing_address' => 'required|string|max:250',
            'payment_method' => 'required|string|max:250',
            'bank' => 'required_if:payment_method,Mobile Banking',
            'paid_amount' => 'required_if:payment_method,Mobile Banking',
            'transaction_id' => 'required_if:payment_method,Mobile Banking',
        ]);

        $product = Product::with('details')->find($request->product_id);

        if (!$product) {
            return response()->json([
                'message' => __('Product not found please try again from the scratch.'),
            ], 404);
        }

        app(ShippingAddressController::class)->store($request);

        app(UserBillingInfoController::class)->store($request);

        $request['payment_by'] = $request->payment_method;
        $order = $this->orderStore($request, $product);

        if ($request->payment_method === 'PaysantsPay') {
            return response()->json([
                'message' => __('Redirecting to payment...'),
                'redirect' => route('customer.payment.paysantspay.page', ['order' => $order->id]),
            ]);
        }

        return response()->json([
            'message' => __('Order place successfully.'),
            'redirect' => route('customer.order-success')
        ]);
    }

    public function orderStore(Request $request, $product)
    {
        $name = $request->first_name;

        $variation = session('variation');
        $order_no = Order::latest()->first()->order_no ?? 1000;
        $order_no = substr($order_no, 3);
        $order_no = 'INV' . ($order_no + 1);
        $subTotal = session('qty') * $product->sale_price;
        $total_discount = $product->unit_price - $product->sale_price;
        if ($product->details->is_free_shipping){
            $shipping_cost = 0;
        } else{
            $shipping_cost = session('area') == 'inside' ? $product->shipping_cost : $product->outside_shipping_cost;
        }

        $shipping_days = session('area') == 'inside' ? optional($product->details)->inside_shipping_days : optional($product->details)->outside_shipping_days;
        $grand_total = $subTotal + $shipping_cost;

        if ($request->get('email') != null) {
            try {
                Mail::to(auth('customer')->user()->email)->send(new OrderPending(['request' => $request, 'name' => $name, 'order_no' => $order_no, 'subTotal' => $subTotal, 'cart' => [$product]]));
            } catch (\Swift_TransportException $e) {
                Session::flash('error', $e->getMessage());
            }
        }

        /** store product details in database */
        $data = [
            'order_no' => $order_no,
            'discount' => $total_discount,
             'coupon_discount' => Cookie::get('coupon_discount'), // Should be change
            'shipping_cost' => $shipping_cost,
            'total_price' => $subTotal,
             'coupon_id' => Cookie::get('coupon_id'), // Should be change
            'shipping_name' => $name,
            'shipping_address_1' => $request->shipping_address,
            'shipping_address_2' => $request->billing_address,
            'shipping_mobile' => $request->mobile,
            'payment_by' => $request->get('payment_method'),
            'user_id' => auth('customer')->id(),
            'user_first_name' => $name,
            'user_address_1' => $request->address_line_one,
            'user_mobile' => auth('customer')->user()->mobile,
            'user_email' => auth('customer')->user()->email,
        ];

        $isCod = $request->get('payment_by') == 'COD';
        $isPaysantsPay = $request->get('payment_by') === 'PaysantsPay';
        $paymentStatus = $isCod ? 'unpaid' : ($isPaysantsPay ? 'pending' : 'paid');
        $paidAmount = $isCod || $isPaysantsPay ? 0 : (float) ($request->paid_amount ?? 0);

        $order = Order::create($data + [
            'payment_status' => $paymentStatus,
            'paid_amount' => $paidAmount,
            'meta' => [
                'bank' => $request->bank,
                'transaction_id' => $request->transaction_id,
            ]
        ]);

        session()->put('order_id', $order->id);

        $data = [
            'seller_id' => $product->seller_id ?? null,
            'user_id' => auth('customer')->id(),
            'order_id' => $order->id,
            'order_stat' => 1,
            'product_id' => $product->id,
            'sale_price' => $product->sale_price,
            'qty' => session('qty'),
            'color' => $variation['color'] ?? null,
            'size' => $variation['size'] ?? null,
            'discount' => $total_discount,
            'shipping_cost' => $shipping_cost,
            'total_shipping_cost' => $shipping_cost,
            'total_price' => $subTotal,
            'grand_total' => session('qty') * $product->sale_price,
            'estimated_shipping_days' => $shipping_days,
        ];

        $details = OrderDetail::create($data);

        $timeline = [
            'order_stat' => 1,
            'product_id' => $product->id,
            'order_stat_datetime' => now(),
            'remarks' => $request->payment_by,
            'order_detail_id' => $details->id,
            'user_id' => auth('customer')->id(),
            'order_stat_desc' => $request->get('order_stat_desc'),
        ];

        // Notification to seller
        $this->SellerNotification($product->seller_id, $order->id, route('seller.orders.index', ['order' => $order->id]), __('Placed new order.'));

        // Stock Management: normalize so "undefined" / empty from frontend never hit the DB
        $sizeId = $this->normalizeVariationId($variation['size_id'] ?? null);
        $colorId = $this->normalizeVariationId($variation['color_id'] ?? null);
        $stockQuery = Productstock::where('product_id', $product->id);
        if ($sizeId !== null) {
            $stockQuery->where('size_id', $sizeId);
        } else {
            $stockQuery->whereNull('size_id');
        }
        if ($colorId !== null) {
            $stockQuery->where('color_id', $colorId);
        } else {
            $stockQuery->whereNull('color_id');
        }
        $stockQuery->decrement('quantities', (int) session('qty', 1));
        $product->decrement('quantity', (int) session('qty', 1));
        OrderTimeline::query()->create($timeline);
        if ($request->code){
            CouponUsage::create(['user_id'=>auth()->id(),'coupon_id'=>Cookie::get('coupon_id')]);
        }



        return $order;
    }

    /**
     * Normalize size_id/color_id from request or session: "undefined", "", or invalid → null.
     */
    private function normalizeVariationId($value): ?int
    {
        if ($value === null || $value === '' || $value === 'undefined') {
            return null;
        }
        $id = is_numeric($value) ? (int) $value : 0;
        return $id > 0 ? $id : null;
    }
}
