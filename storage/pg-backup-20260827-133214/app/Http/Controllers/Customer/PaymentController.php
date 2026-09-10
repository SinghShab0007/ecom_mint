<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\NotifyHelper;
use App\Mail\OrderPending;
use App\Models\Api\CouponUsage;
use App\Models\Frontend\Coupon;
use App\Services\PaysantsPayService;
use Illuminate\Http\Request;
use App\Models\Frontend\Order;
use App\Models\Frontend\Product;
use App\Models\Frontend\CartItem;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Frontend\OrderDetail;
use Illuminate\Support\Facades\Mail;
use App\Models\Frontend\OrderTimeline;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Frontend\ShippingAddressController;
use App\Http\Controllers\Frontend\UserBillingInfoController;
use App\Models\Productstock;

class PaymentController extends Controller
{
    use NotifyHelper;

    public function __construct()
    {
        $this->middleware('auth:customer')->except(['paysantsPayNotify', 'paysantsPayReturn']);
    }

    public function index(Request $request)
    {
        // If "same as billing" is checked, mirror billing → shipping server-side too.
        if ($request->boolean('same_as_billing')) {
            $request->merge([
                'shipping_address'   => $request->input('billing_address'),
                'shipping_address_2' => $request->input('billing_address_2'),
                'shipping_pincode'   => $request->input('billing_pincode'),
                'shipping_city'      => $request->input('billing_city'),
                'shipping_state'     => $request->input('billing_state'),
                'shipping_district'  => $request->input('billing_district'),
            ]);
        }

        $this->validate($request, [
            'first_name'         => 'required|max:100',
            'mobile'             => 'required|string|max:15',
            'billing_address'    => 'required|string|max:250',
            'billing_address_2'  => 'nullable|string|max:250',
            'billing_pincode'    => 'required|digits:6',
            'billing_city'       => 'required|string|max:100',
            'billing_state'      => 'required|string|max:100',
            'billing_district'   => 'required|string|max:100',
            'shipping_address'   => 'required|string|max:250',
            'shipping_address_2' => 'nullable|string|max:250',
            'shipping_pincode'   => 'required|digits:6',
            'shipping_city'      => 'required|string|max:100',
            'shipping_state'     => 'required|string|max:100',
            'shipping_district'  => 'required|string|max:100',
            'payment_method'     => 'required|string|max:250',
            'bank'               => 'required_if:payment_method,mobile_banking',
            'paid_amount'        => 'required_if:payment_method,mobile_banking',
            'transaction_id'     => 'required_if:payment_method,mobile_banking',
        ]);

        $cart = json_decode(Cookie::get('cart'));
        if (!$cart) {
            return response()->json([
                'message' => __('The cart is empty.'),
            ], 404);
        }

        app(ShippingAddressController::class)->store($request);

        app(UserBillingInfoController::class)->store($request);

        $request['payment_by'] = $request->payment_method;
        $order = $this->orderStore($request);

        Cookie::queue(Cookie::forget('cart'));
        Cookie::queue(Cookie::forget('total'));
        Cookie::queue(Cookie::forget('subTotal'));
        Cookie::queue(Cookie::forget('coupon_id'));
        Cookie::queue(Cookie::forget('coupon_infos'));
        Cookie::queue(Cookie::forget('totalShipping'));
        Cookie::queue(Cookie::forget('coupon_discount'));

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

    public function orderStore(Request $request)
    {
        $cart = json_decode(Cookie::get('cart'));

        $name = $request->first_name;

        $order_no = Order::latest()->first()->order_no ?? 1000;
        $order_no = substr($order_no, 3);
        $order_no = 'INV' . ($order_no + 1);
        $subTotal = Cookie::get('subTotal');
        $total_discount = Cookie::get('total_discount') + (Cookie::get('coupon_discount') ?? 0);

        $indiaCountryId = \App\Models\Backend\Country::query()
            ->where('iso_no', 'IN')
            ->orWhere('name', 'India')
            ->orWhere('nick_name', 'India')
            ->value('id');

        $shippingLine1 = trim(($request->shipping_address ?? '') . ($request->shipping_address_2 ? ', ' . $request->shipping_address_2 : ''));
        $billingLine1  = trim(($request->billing_address ?? '')  . ($request->billing_address_2  ? ', ' . $request->billing_address_2  : ''));

        /** store product details in database */
        $data = [
            'order_no' => $order_no,
            'discount' => $total_discount,
            'vat' => Cookie::get('total_vat') ?? 0,
            'coupon_discount' => Cookie::get('coupon_discount'),
            'shipping_cost' => Cookie::get('totalShipping'),
            'total_price' => Cookie::get('subTotal'),
            'coupon_id' => Cookie::get('coupon_id'),
            'shipping_name' => $name,
            'shipping_address_1' => $shippingLine1,
            'shipping_address_2' => $request->shipping_address_2,
            'shipping_mobile' => $request->mobile,
            'shipping_post' => $request->shipping_pincode,
            'shipping_town' => $request->shipping_city,
            'shipping_country_id' => $indiaCountryId,
            'shipping_note' => 'State: ' . ($request->shipping_state ?? '') . ' | District: ' . ($request->shipping_district ?? ''),
            'payment_by' => $request->get('payment_method'),
            'user_id' => auth('customer')->id(),
            'user_first_name' => $name,
            'user_address_1' => $billingLine1,
            'user_post_code' => $request->billing_pincode,
            'user_city' => $request->billing_city,
            'user_country_id' => $indiaCountryId,
            'user_mobile' => auth('customer')->user()->mobile,
            'user_email' => auth('customer')->user()->email,
        ];

        $isCod = $request->get('payment_by') == 'COD';
        $isPaysantsPay = $request->get('payment_by') === 'PaysantsPay';
        $paymentStatus = $isCod ? 'unpaid' : ($isPaysantsPay ? 'pending' : 'paid');
        $paidAmount = $isCod || $isPaysantsPay ? 0 : (float) $request->paid_amount;

        $order = Order::create($data + [
            'payment_status' => $paymentStatus,
            'paid_amount' => $paidAmount,
            'meta' => [
                'bank' => $request->bank,
                'transaction_id' => $request->transaction_id,
                'country' => $request->country ?? 'India',
                'billing' => [
                    'address_1' => $request->billing_address,
                    'address_2' => $request->billing_address_2,
                    'city'      => $request->billing_city,
                    'district'  => $request->billing_district,
                    'state'     => $request->billing_state,
                    'pincode'   => $request->billing_pincode,
                ],
                'shipping' => [
                    'address_1' => $request->shipping_address,
                    'address_2' => $request->shipping_address_2,
                    'city'      => $request->shipping_city,
                    'district'  => $request->shipping_district,
                    'state'     => $request->shipping_state,
                    'pincode'   => $request->shipping_pincode,
                ],
                'same_as_billing' => $request->boolean('same_as_billing'),
            ]
        ]);

        session()->put('order_id', $order->id);
        $coupon_id= Cookie::get('coupon_id');
        if (!empty($coupon_id)){
            CouponUsage::create(['user_id'=>$data['user_id'],'coupon_id'=>$data['coupon_id']]);

            $couponIfo = Coupon::where('id',$order->coupon_id)->first();
            if ($couponIfo->type=='product'){
                $couponproductIds = json_decode($couponIfo->details)->product_id;
            }
        }

        foreach ($cart as $item) {
            $product = Product::query()->findOrFail($item->id);

            if ($product->is_manage_stock && $product->quantity < $item->quantity) {
                continue;
            }
            if (!empty($coupon_id) && $couponIfo->type=='product'){
                if (in_array($item->id,$couponproductIds)){
                    $coupon_discount = ($couponIfo->discount_type == 'percent')
                        ? (CartItem::price($item->id,$item->quantity) ) * ($couponIfo->discount / 100)
                        : $couponIfo->discount;

                }else{
                    $coupon_discount =0;
                }

            }

            $data = [
                'seller_id' => $product->seller_id ?? null,
                'user_id' => auth('customer')->id(),
                'order_id' => $order->id,
                'order_stat' => 1,
                'product_id' => $item->id,
                'sale_price' => CartItem::price($item->id),
                'qty' => $item->quantity,
                'color' => $item->color ?? null,
                // 'courier' => $item->courier ?? null,
                'size' => $item->size ?? null,
                'discount' => $product->discount, // Should be changed, have to calculate with the coupon(indvitual product)
                'coupon_discount' => $coupon_discount ?? 0,
                // 'tax' => $item->vat ?? 0,
                'shipping_cost' => CartItem::shipping($item->id),
                'total_shipping_cost' => CartItem::shipping($item->id, $item->quantity),
                'total_price' => CartItem::price($item->id, $item->quantity),
                'grand_total' => CartItem::price($item->id, $item->quantity) + CartItem::shipping($item->id, $item->quantity),
                'inside_shipping_days' => CartItem::estimatedShippingDays($item->id),
            ];

            $details = OrderDetail::create($data);

            $timeline = [
                'order_detail_id' => $details->id,
                'order_stat' => 2,
                'order_stat_desc' => $request->get('order_stat_desc'),
                'order_stat_datetime' => now(),
                'user_id' => auth('customer')->id(),
                'remarks' => '',
                'product_id' => $item->id,
            ];

            // Notification to seller
            // $this->SellerNotification($product->seller_id, $order->id, route('seller.orders.index', ['order' => $order->id]), __('Placed new order.')); // Should be change.

            // Stock Management
            if (isset($item->size_id) || isset($item->color_id)) {
                Productstock::where('product_id', $item->id)->where('size_id', $item->size_id)->where('color_id', $item->color_id)->decrement('quantities', $item->quantity);
            }
            $product->decrement('quantity', $item->quantity);
            OrderTimeline::query()->create($timeline);
        }

        Cookie::queue(Cookie::forget('coupon_discount'));
        Cookie::queue(Cookie::forget('total_vat'));
        Cookie::queue(Cookie::forget('shipping'));

        $this->sendOrderConfirmationEmail($order, $request, $name, $cart, $subTotal);

        return $order;
    }

    private function sendOrderConfirmationEmail(Order $order, Request $request, string $name, $cart, $subTotal): void
    {
        $recipient = auth('customer')->user()->email ?? null;
        if (!$recipient) {
            return;
        }

        $payload = [
            'request'      => $request,
            'name'         => $name,
            'order_no'     => $order->order_no,
            'order_id'     => $order->id,
            'subTotal'     => $subTotal,
            'shippingCost' => $order->shipping_cost ?? 0,
            'couponDiscount' => $order->coupon_discount ?? 0,
            'grandTotal'   => ($subTotal + ($order->shipping_cost ?? 0)) - ($order->coupon_discount ?? 0),
            'paymentBy'    => $order->payment_by,
            'paymentStatus'=> $order->payment_status,
            'mobile'       => $request->mobile,
            'email'        => $recipient,
            'cart'         => $cart,
            'billing'      => [
                'address_1' => $request->billing_address,
                'address_2' => $request->billing_address_2,
                'city'      => $request->billing_city,
                'district'  => $request->billing_district,
                'state'     => $request->billing_state,
                'pincode'   => $request->billing_pincode,
                'country'   => 'India',
            ],
            'shipping'     => [
                'address_1' => $request->shipping_address,
                'address_2' => $request->shipping_address_2,
                'city'      => $request->shipping_city,
                'district'  => $request->shipping_district,
                'state'     => $request->shipping_state,
                'pincode'   => $request->shipping_pincode,
                'country'   => 'India',
            ],
        ];

        try {
            Mail::to($recipient)->send(new OrderPending($payload));
        } catch (\Throwable $e) {
            Log::warning('Order confirmation email failed: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'recipient' => $recipient,
            ]);
        }
    }

    /**
     * Display success message
     *
     * @return View
     */
    public function paymentSuccess(): View
    {
        $msg = trans('Thank you for your payment');
        return view('customer.checkout.payment-success', compact('msg'));
    }

    public function orderSuccess()
    {
        $order = Order::with('items')->findOrFail(session('order_id'));
        session()->forget('order_id');
        return view('customer.checkout.payment-success', compact('order'));
    }

    /**
     * Show "Redirecting to payment" page; frontend will call create endpoint and redirect to gateway.
     */
    public function paysantsPayPage(Order $order)
    {
        if ($order->user_id !== auth('customer')->id()) {
            abort(403);
        }
        if ($order->payment_status !== 'pending' || $order->payment_by !== 'PaysantsPay') {
            return redirect()->route('customer.order')->with('error', __('Invalid order for payment.'));
        }
        return view('customer.checkout.paysantspay-redirect', compact('order'));
    }

    /**
     * Create PaysantsPay payment and return payment link (and optional QR).
     */
    public function paysantsPayCreate(Request $request)
    {
        $orderId = $request->get('order_id');
        $order = Order::query()->find($orderId);

        if (!$order || $order->user_id !== auth('customer')->id()) {
            return response()->json(['success' => false, 'message' => __('Order not found.')], 404);
        }
        if ($order->payment_status !== 'pending' || $order->payment_by !== 'PaysantsPay') {
            return response()->json(['success' => false, 'message' => __('Invalid order.')], 400);
        }

        $config = config('services.paysantspay');
        if (empty($config['merchant_id']) || empty($config['sign_key'])) {
            $gateway = \App\Models\Frontend\PaymentGateway::query()
                ->where('name', 'PaysantsPay')
                ->where('status', 1)
                ->first();
            if ($gateway && !empty($gateway->configuration)) {
                $decoded = json_decode($gateway->configuration, true);
                if (is_array($decoded)) {
                    $config = array_merge($config, [
                        'merchant_id' => $decoded['merchant_id'] ?? $decoded['MERCHANT_ID'] ?? '',
                        'app_id' => $decoded['app_id'] ?? $decoded['APP_ID'] ?? '',
                        'sign_key' => $decoded['sign_key'] ?? $decoded['SIGN_KEY'] ?? '',
                        'notify_url' => $decoded['notify_url'] ?? $config['notify_url'] ?? url('/payment/paysantspay/notify'),
                        'front_callback_url' => $decoded['front_callback_url'] ?? $config['front_callback_url'] ?? url('/payment/paysantspay/return'),
                    ]);
                }
            }
        }
        // Ensure absolute URLs (env may contain "${APP_URL}" which is not always expanded)
        $config['notify_url'] = $this->paysantsPayAbsoluteUrl($config['notify_url'] ?? '', '/payment/paysantspay/notify');
        $config['front_callback_url'] = $this->paysantsPayAbsoluteUrl($config['front_callback_url'] ?? '', '/payment/paysantspay/return');

        // Device-based flow: mobile → payment page (LINK), desktop → UPI Intent QR (INTENT)
        $config['pay_type'] = $this->isPaysantsPayMobile($request) ? 'LINK' : 'INTENT';

        $service = new PaysantsPayService($config);
        $result = $service->createPayment($order);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? __('Failed to create payment.'),
            ], 400);
        }

        $response = [
            'success' => true,
            'paymentLink' => $result['data']['paymentLink'] ?? '',
            'qrcode' => $result['data']['qrcode'] ?? '',
            'isMobile' => $this->isPaysantsPayMobile($request),
        ];
        if (!empty($response['qrcode'])) {
            $response['qrcode_expires_at'] = now()->addMinutes(15)->timestamp;
        }
        return response()->json($response);
    }

    /**
     * Gateway server-to-server notify (webhook). Excluded from CSRF and auth.
     */
    public function paysantsPayNotify(Request $request)
    {
        $notifyReq = $request->all();
        $service = new PaysantsPayService();
        $result = $service->handleNotify($notifyReq);

        if (!$result['success']) {
            return response()->json($result);
        }

        $outTradeNo = $notifyReq['outTradeNo'] ?? $notifyReq['out_trade_no'] ?? '';
        $order = $this->findOrderByOutTradeNo($outTradeNo);

        if ($order) {
            $status = $result['data']['status'] ?? '';
            if ($status === 'success') {
                $order->update([
                    'payment_status' => 'paid',
                    'paid_amount' => (float) ($order->total_price + $order->shipping_cost - ($order->coupon_discount ?? 0)),
                    'meta' => array_merge($order->meta ?? [], [
                        'gateway_trade_no' => $notifyReq['platTradeNo'] ?? $notifyReq['plat_trade_no'] ?? null,
                    ]),
                ]);
            } elseif ($status === 'failure') {
                $order->update(['payment_status' => 'failed']);
            }
        }

        return response()->json($result);
    }

    /**
     * Front callback after customer completes payment on gateway; redirect to order success.
     */
    public function paysantsPayReturn(Request $request)
    {
        $orderNo = $request->get('order_no') ?? $request->get('outTradeNo');
        $order = $this->findOrderByOutTradeNo($orderNo);

        if ($order) {
            session()->put('order_id', $order->id);
        }

        return redirect()->route('customer.order-success');
    }

    /**
     * Resolve outTradeNo to Order. Gateway sends 6–32 alphanumeric (we use O + zero-padded id).
     */
    private function findOrderByOutTradeNo(string $outTradeNo): ?Order
    {
        if (preg_match('/^O\d+$/', $outTradeNo)) {
            $id = (int) substr($outTradeNo, 1);
            return Order::query()->find($id);
        }
        return Order::query()->where('order_no', $outTradeNo)->first();
    }

    /**
     * Detect mobile device for PaysantsPay: mobile → show payment page, desktop → show UPI QR.
     */
    private function isPaysantsPayMobile(Request $request): bool
    {
        $ua = $request->userAgent() ?? '';
        return (bool) preg_match('/Mobile|Android|iPhone|iPad|iPod|webOS|BlackBerry|IEMobile|Opera Mini/i', $ua);
    }

    /**
     * Return absolute URL for PaysantsPay. Replaces ${APP_URL} or uses app url when empty/invalid.
     */
    private function paysantsPayAbsoluteUrl(string $url, string $defaultPath): string
    {
        if ($url === '' || str_contains($url, '${')) {
            return url($defaultPath);
        }
        $url = str_replace('${APP_URL}', rtrim(config('app.url'), '/'), $url);
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }
        return url($defaultPath);
    }
}
