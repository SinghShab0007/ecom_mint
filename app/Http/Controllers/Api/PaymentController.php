<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ResponseMessage;
use App\Mail\OrderPending;
use App\Models\Api\Currency;
use App\Models\Api\Order;
use App\Models\Api\OrderDetail;
use App\Models\Api\OrderPayment;
use App\Models\Api\OrderTimeline;
use App\Models\Api\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    use ApiResponse,ResponseMessage;

    public function order(Request $request): JsonResponse
    {
        $this->validate($request,[
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'user_address_1' => 'required|max:100',
            'user_mobile' => 'required|numeric',
            'user_email' => 'required|email',
            'user_post_code' => 'required',
            'user_city' => 'required',
            'user_country_id' => 'required',
            'shipping_name' => 'required',
            'shipping_mobile' => 'required|numeric',
            'shipping_email' => 'required|email',
            'shipping_post' => 'required',
            'shipping_town' => 'required',
            'shipping_country_id' => 'required',
            'address_line_one' => 'required',
            'address_line_two' => 'sometimes|max:255',
            'cart' => 'required|array',
            'cart.*.id' => 'required',
            'cart.*.price' => 'required',
            'cart.*.quantity' => 'required',
            'cart.*.shipping_cost' => 'required',
            'cart.*.product_price_total' => 'required',
            'cart.*.inside_shipping_days' => 'required',
            'payment_by' => 'required',
            'currency' => 'required|array',
            'currency.id' => 'required',
            'currency.exchange_rate' => 'required',
            'subTotal' => 'required',
            'totalShipping' => 'required',
            'total' => 'required',

        ]);

        try {

            if($request->input('payment_by')=='paypal'){
                $request['order_stat_desc'] = 'Order placed and confirmed via paypal';
            }if ($request->input('payment_by')=='stripe'){
                $request['order_stat_desc'] = 'Order placed and confirmed via stripe';
            }else{
                $request['order_stat_desc'] = 'Order placed via cash on delivery';
            }
            $shipping = $request->except(['_token']);
            $order = $this->orderStore($request, json_encode($shipping));
            if($order){
                app(ShippingAddressController::class)->store($request);

                app(UserBillingInfoController::class)->store($request);

                $similarProducts = Product::query()->inRandomOrder()->take(5)->get();

                return $this->successResponse(compact('order','similarProducts'), $this->create_success_message['message'], Response::HTTP_CREATED);

            }else{
                return $this->errorResponse($this->create_fail_message['message'], Response::HTTP_NOT_FOUND);
            }


        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function payment(Request $request): JsonResponse
    {
        $this->validate($request,[
            'card_number' => 'required|digits_between:16,20',
            'order_id' => 'required',
            'currency_cc' => 'required',
            'exchange_rate' => 'required'
        ]);

        try {
            $order_id = $request->input('order_id');

            if ($request->has('currency_cc')) {
                $currency = $request->input('currency_cc');
            }

            $cc = $currency ?? 'usd';


            // store data in payment table
            $data = [
                'order_id' =>  $order_id,
                'payment_type' => 1,
                'card_no' => $request->card_number,
                'card_name' => 1,
                'tax' => 0,
                'currency' => $cc,
                'exchange_rate' => $currency ? $request->exchange_rate : 1,
                'created_by' => auth('api')->id(),
                'updated_by' => auth('api')->id()
            ];

            $payment = OrderPayment::query()->create($data);

            return $this->successResponse($payment, $this->create_success_message['message'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


    public function orderStore(Request $request,$shipping = null)
    {
        $cart = $request->input('cart');

        $shipping = json_decode($shipping);

        if($request->has('currency')){
            $currency =  (object) $request->input('currency');
        }else{
            $currency = Currency::query()->find(maanAppearance('currency_id'));
        }

        $name = auth('api')->user()->first_name;

        $order_no = Order::all()->last()->order_no ?? 1000;
        $order_no = substr($order_no,3);
        $order_no = 'INV'.($order_no + 1);
        $subTotal = $request->input('subTotal');

        if($request->get('email') != null){
            try {
                Mail::to(auth('api')->user()->email)->send(new OrderPending(['request'=>$request,'name'=>$name,'order_no'=>$order_no,'subTotal'=>$subTotal,'cart'=>$cart]));
            }catch (\Swift_TransportException $e){
                Log::error($e->getMessage());
            }
        }

        /** store product details in database */
        $data = [
            'order_no'=> $order_no,
            'discount'=> $request->discount??null,
            'tax'=> $request->tax??null,
            'shipping_cost' => $request->input('totalShipping'),
            'total_price'=> $request->input('subTotal'),
            'currency_id'=> $currency->id,
            'exchange_rate'=> $currency->exchange_rate,
            'shipping_name'=> $shipping->shipping_name,
            'shipping_address_1'=> $shipping->address_line_one,
            'shipping_address_2'=> $shipping->address_line_two??'',
            'shipping_mobile' => $shipping->shipping_mobile,
            'shipping_email' => $shipping->shipping_email,
            'shipping_post' => $shipping->shipping_post,
            'shipping_town' => $shipping->shipping_town,
            'shipping_country_id' => $shipping->shipping_country_id,
            'shipping_note' => $shipping->shipping_note,
            'payment_by'=> $request->get('payment_by'),
            'user_id'=> auth('api')->id(),
            'user_first_name'=> $request->first_name,
            'user_last_name'=> $request->last_name,
            'user_address_1'=> $request->user_address_1,
            'user_post_code'=> $request->user_post_code,
            'user_city'=> $request->user_city,
            'user_country_id' => $request->user_country_id,
            'user_mobile'=> $request->user_mobile,
            'user_email'=> $request->user_email,
        ];

        $order = Order::query()->create($data);

        /** store product details in database */
        foreach($cart as  $item){
           $item = (object) $item;
            $product = Product::query()->find($item->id);
            if($product) {
                $data = [
                    'seller_id' => $product->seller_id ?? null,
                    'user_id' => auth('api')->id(),
                    'order_id' => $order->id,
                    'order_stat' => 2,
                    'product_id' => $item->id,
                    'sale_price' => $item->price,
                    'qty' => $item->quantity,
                    'color' => $item->color ?? null,
                    'size' => $item->size ?? null,
                    'discount' => 0,
                    'tax' => 0,
                    'shipping_cost' => $item->shipping_cost,
                    'total_shipping_cost' => $item->shipping_cost * $item->quantity,
                    'total_price' => $item->product_price_total,
                    'grand_total' => $item->product_price_total + ($item->shipping_cost * $item->quantity),
                    'currency_id' => $currency->id,
                    'exchange_rate' => $currency->exchange_rate,
                    'inside_shipping_days' => $item->inside_shipping_days,
                ];

                $details = OrderDetail::query()->create($data);

                $timeline = [
                    'order_detail_id' => $details->id,
                    'order_stat' => 2,
                    'order_stat_desc' => $request->get('order_stat_desc'),
                    'order_stat_datetime' => now(),
                    'user_id' => auth('api')->id(),
                    'remarks' => '',
                    'product_id' => $item->id,
                ];

                OrderTimeline::query()->create($timeline);
            }else{
                return false;
            }
        }
        return $order;
    }

    /**
     * get the stripe payment info
     */
    public function stripeInfo(){
        $stripe_secret = config('stripe.secret');
        if($stripe_secret){
            return $this->successResponse(compact('stripe_secret'),$this->load_success['message']);
        }else{
            return $this->errorResponse('Stripe secret is not Found');
        }
    }

    /**
     * get the paypal payment info
     */
    public function paypalInfo(){
        $clientId = config('paypal.id');
        $clientSecret = config('paypal.secret');
        $account = config('paypal.account');
        $mode = config('paypal.mode');
        if($clientId && $clientSecret){
            return $this->successResponse(compact('clientId','clientSecret','account','mode'),$this->load_success['message']);
        }else{
            return $this->errorResponse('PayPal info is not Found');
        }
    }
}
