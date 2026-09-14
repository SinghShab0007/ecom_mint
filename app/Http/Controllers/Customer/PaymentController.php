<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\NotifyHelper;
use App\Mail\OrderPending;
use App\Models\Api\CouponUsage;
use App\Models\Frontend\Coupon;
use App\Services\PaydharaService;
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

    /** Value stored in orders.payment_by for the online gateway. */
    public const GATEWAY = 'Paydhara';

    /** How long an issued Paydhara payment link is reused before minting a new one. */
    private const LINK_REUSE_MINUTES = 15;

    /**
     * Customer-facing label for a stored payment_by value.
     *
     * orders.payment_by holds the internal gateway name, which should never be
     * shown to a buyer - the checkout calls it "Pay Online", so receipts and
     * emails must say the same thing.
     */
    public static function paymentLabel(?string $paymentBy): string
    {
        switch ($paymentBy) {
            case self::GATEWAY:
                return __('Pay Online');
            case 'COD':
                return __('Cash On Delivery');
            default:
                return (string) $paymentBy;
        }
    }

    public function __construct()
    {
        $this->middleware('auth:customer')->except(['paydharaWebhook', 'paydharaReturn']);
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

        if ($request->payment_method === self::GATEWAY) {
            // Online payment: the order exists only to carry a reference to the
            // gateway. It stays unpaid, and no confirmation goes out until the
            // gateway tells us the money arrived.
            return response()->json([
                'message' => __('Redirecting to payment...'),
                'redirect' => route('customer.payment.paydhara.page', ['order' => $order->id]),
            ]);
        }

        // COD (and anything else settled offline): the order is placed now.
        $this->sendOrderConfirmationEmail($order);

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
        $isGateway = $request->get('payment_by') === self::GATEWAY;
        $paymentStatus = $isCod ? 'unpaid' : ($isGateway ? 'pending' : 'paid');
        $paidAmount = $isCod || $isGateway ? 0 : (float) $request->paid_amount;

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

        // The confirmation email is NOT sent here. An order created for an online
        // payment is still unpaid at this point, so mailing now would confirm an
        // order the customer has not yet paid for. index() sends it for COD, and
        // settleFromGateway() sends it once the gateway confirms payment.

        return $order;
    }

    /**
     * Send the order confirmation email - exactly once per order.
     *
     * Everything is derived from the Order row rather than the request/cart,
     * because this also runs from the gateway webhook where neither exists.
     */
    private function sendOrderConfirmationEmail(Order $order): void
    {
        $meta = $order->meta ?? [];

        // Idempotency guard. settleFromGateway() can be reached from the webhook,
        // the browser return and the status poll - without this the customer
        // would get the same confirmation two or three times.
        if (!empty($meta['confirmation_mail_sent_at'])) {
            return;
        }

        $recipient = $order->user_email;
        if (!$recipient) {
            return;
        }

        // Claim the send before dispatching so concurrent callbacks cannot race.
        $meta['confirmation_mail_sent_at'] = now()->toDateTimeString();
        $order->forceFill(['meta' => $meta])->save();

        $order->loadMissing('items');

        // The mail template iterates cart-shaped items (->id, ->quantity), so
        // map the persisted order lines onto that shape.
        $cart = $order->items->map(fn ($item) => (object) [
            'id' => $item->product_id,
            'quantity' => $item->qty,
        ]);

        $subTotal = (float) $order->total_price;
        $shipping = (float) $order->shipping_cost;
        $discount = (float) ($order->coupon_discount ?? 0);

        $payload = [
            'name'           => trim($order->shipping_name ?: $order->user_first_name) ?: __('Customer'),
            'order_no'       => $order->order_no,
            'order_id'       => $order->id,
            'subTotal'       => $subTotal,
            'shippingCost'   => $shipping,
            'couponDiscount' => $discount,
            'grandTotal'     => $subTotal + $shipping - $discount,
            'paymentBy'      => self::paymentLabel($order->payment_by),
            'paymentStatus'  => $order->payment_status,
            'mobile'         => $order->shipping_mobile ?: $order->user_mobile,
            'email'          => $recipient,
            'cart'           => $cart,
            'billing'        => $meta['billing'] ?? [],
            'shipping'       => $meta['shipping'] ?? [],
        ];

        $orderId = $order->id;

        // Deferred to the terminating stage so a slow SMTP handshake cannot hold
        // the request open until PHP-FPM times out (which surfaces as a 502).
        app()->terminating(function () use ($recipient, $payload, $orderId) {
            try {
                Mail::to($recipient)->send(new OrderPending($payload));
            } catch (\Throwable $e) {
                Log::warning('Order confirmation email failed: ' . $e->getMessage(), [
                    'order_id' => $orderId,
                    'recipient' => $recipient,
                ]);
            }
        });
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
     * Interstitial that creates the gateway order and forwards the buyer.
     */
    public function paydharaPage(Order $order)
    {
        if ($order->user_id !== auth('customer')->id()) {
            abort(403);
        }
        if ($order->payment_status !== 'pending' || $order->payment_by !== self::GATEWAY) {
            return redirect()->route('customer.order')->with('error', __('Invalid order for payment.'));
        }

        return view('customer.checkout.paydhara-redirect', compact('order'));
    }

    /**
     * Create the Paydhara order and hand back its hosted payment link.
     */
    public function paydharaCreate(Request $request)
    {
        $order = Order::query()->find($request->get('order_id'));

        if (!$order || $order->user_id !== auth('customer')->id()) {
            return response()->json(['success' => false, 'message' => __('Order not found.')], 404);
        }
        if ($order->payment_status !== 'pending' || $order->payment_by !== self::GATEWAY) {
            return response()->json(['success' => false, 'message' => __('Invalid order.')], 400);
        }

        $service = new PaydharaService();
        if (!$service->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => __('Payment gateway is not configured. Please contact support.'),
            ], 400);
        }

        $meta = $order->meta ?? [];

        // Reuse a link issued moments ago. The redirect page calls this on every
        // load, so without this each refresh opened a NEW order at Paydhara -
        // which is what exhausted their rate limit ("Too many requests").
        $existingLink = $meta['paydhara_payment_link'] ?? null;
        $issuedAt = isset($meta['paydhara_link_issued_at']) ? strtotime($meta['paydhara_link_issued_at']) : 0;

        if ($order->payment_ref && $existingLink && $issuedAt > now()->subMinutes(self::LINK_REUSE_MINUTES)->timestamp) {
            return response()->json([
                'success'      => true,
                'payment_link' => $existingLink,
            ]);
        }

        $refId = PaydharaService::buildRefId($order->id);
        $result = $service->createOrder($order, $refId);

        if (!$result['success']) {
            return response()->json(['success' => false, 'message' => $result['message']], 400);
        }

        // Keep every refid ever issued for this order. A customer may pay on an
        // older link after a newer one was created; its callback must still
        // resolve to this order instead of being dropped as unknown.
        $refids = $meta['paydhara_refids'] ?? [];
        if (!empty($meta['paydhara_refid']) && !in_array($meta['paydhara_refid'], $refids, true)) {
            $refids[] = $meta['paydhara_refid'];
        }
        $refids[] = $refId;

        $order->forceFill([
            'payment_ref' => $refId,
            'meta' => array_merge($meta, [
                'gateway'                 => self::GATEWAY,
                'paydhara_refid'          => $refId,
                'paydhara_refids'         => array_values(array_unique($refids)),
                'paydhara_txn_id'         => $result['transaction_id'],
                'paydhara_reference'      => $result['reference_id'],
                'paydhara_payment_link'   => $result['payment_link'],
                'paydhara_link_issued_at' => now()->toDateTimeString(),
            ]),
        ])->save();

        return response()->json([
            'success'      => true,
            'payment_link' => $result['payment_link'],
        ]);
    }

    /**
     * Server-to-server webhook. Excluded from CSRF and auth.
     *
     * Paydhara publishes no signature scheme and no payload contract, so the
     * body is treated purely as a hint about *which* order to re-check; the
     * paid/failed decision always comes from a fresh transaction-status call.
     */
    public function paydharaWebhook(Request $request)
    {
        $payload = $request->all();
        Log::info('Paydhara webhook received', ['payload' => $payload]);

        $refId = $this->extractRefId($payload);
        if ($refId === null) {
            return response()->json(['success' => false, 'message' => 'refid missing'], 400);
        }

        $order = $this->findOrderByRefId($refId);
        if (!$order) {
            Log::warning('Paydhara webhook for unknown refid', ['refid' => $refId]);
            return response()->json(['success' => false, 'message' => 'order not found'], 404);
        }

        $this->settleFromGateway($order, $refId);

        return response()->json(['success' => true]);
    }

    /**
     * Buyer returns from the hosted page. Verifies before showing an outcome.
     */
    public function paydharaReturn(Request $request)
    {
        $refId = $this->extractRefId($request->all());
        $order = $refId ? $this->findOrderByRefId($refId) : null;

        // The hosted page may return without any reference, so fall back to the
        // pending order this session just created.
        if (!$order && session('order_id')) {
            $order = Order::query()->find(session('order_id'));
        }

        if (!$order) {
            return redirect()->route('customer.order');
        }

        if ($order->payment_status === 'pending' && ($refId || $order->payment_ref)) {
            $this->settleFromGateway($order, $refId ?: $order->payment_ref);
            $order->refresh();
        }

        session()->put('order_id', $order->id);

        if ($order->payment_status === 'paid') {
            return redirect()->route('customer.order-success');
        }

        return redirect()->route('customer.order')
            ->with('error', __('We could not confirm your payment. If money was debited it will be verified shortly.'));
    }

    /**
     * Lets the waiting page poll for an outcome without trusting the browser.
     */
    public function paydharaStatus(Request $request)
    {
        $order = Order::query()->find($request->get('order_id'));

        if (!$order || $order->user_id !== auth('customer')->id()) {
            return response()->json(['success' => false, 'message' => __('Order not found.')], 404);
        }

        if ($order->payment_status === 'pending' && $order->payment_ref) {
            $this->settleFromGateway($order, $order->payment_ref);
            $order->refresh();
        }

        return response()->json([
            'success'        => true,
            'payment_status' => $order->payment_status,
            'redirect'       => $order->payment_status === 'paid' ? route('customer.order-success') : null,
        ]);
    }

    /**
     * Single place where an order's paid/failed state is decided, always from
     * an authoritative status lookup rather than any caller-supplied data.
     */
    private function settleFromGateway(Order $order, string $refId): void
    {
        if ($order->payment_status === 'paid') {
            return;
        }

        $status = (new PaydharaService())->transactionStatus($refId);

        $meta = array_merge($order->meta ?? [], [
            'paydhara_state'    => $status['state'],
            'paydhara_utr'      => $status['utr'],
            'paydhara_verified' => now()->toDateTimeString(),
        ]);

        if ($status['state'] === 'success') {
            $order->forceFill([
                'payment_status' => 'paid',
                'paid_amount'    => PaydharaService::orderAmount($order),
                'meta'           => $meta,
            ])->save();

            // Payment confirmed - this is the point the order is actually placed.
            $this->sendOrderConfirmationEmail($order->refresh());

            return;
        }

        if ($status['state'] === 'failed') {
            $order->forceFill(['payment_status' => 'failed', 'meta' => $meta])->save();
            return;
        }

        // pending / unknown - leave the order pending and keep the audit trail.
        $order->forceFill(['meta' => $meta])->save();
    }

    /**
     * Resolve an order from any refid ever issued for it - the current
     * payment_ref, or an earlier one kept in meta.paydhara_refids.
     */
    private function findOrderByRefId(string $refId): ?Order
    {
        return Order::query()->where('payment_ref', $refId)->first()
            ?? Order::query()->whereJsonContains('meta->paydhara_refids', $refId)->first();
    }

    /** Pull the merchant reference out of a webhook/return payload. */
    private function extractRefId(array $payload): ?string
    {
        foreach (['refid', 'ref_id', 'refId', 'reference', 'merchant_ref'] as $key) {
            if (!empty($payload[$key]) && is_string($payload[$key])) {
                return $payload[$key];
            }
            if (!empty($payload['data'][$key]) && is_string($payload['data'][$key])) {
                return $payload['data'][$key];
            }
        }
        return null;
    }
}
