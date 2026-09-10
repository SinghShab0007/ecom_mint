<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ResponseMessage;
use App\Models\Api\Coupon;
use App\Models\Api\CouponUsage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CouponController extends Controller
{
    use ApiResponse, ResponseMessage;

    /**
     * Store customer review in storage
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function productCoupon(Request $request): JsonResponse
    {
        $product_coupons = Coupon::query()->where('type', 'product')->paginate(request('per_page', 20));

        return $this->successResponse($product_coupons, $this->load_success['message'], Response::HTTP_OK);
    }

    public function cartCoupon(Request $request): JsonResponse
    {
        $cart_coupons = Coupon::query()->where('type', 'cart')->paginate(request('per_page', 20));

        return $this->successResponse($cart_coupons, $this->load_success['message'], Response::HTTP_OK);
    }

    public function verifyCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required'
        ]);

        $coupon = Coupon::query()
            ->where('code', $request->code)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry! No Coupon found!'
            ], 200);
        }
        $usage = CouponUsage::query()->where('coupon_id',$coupon->id)->get();
        $exists = CouponUsage::query()->where('coupon_id',$coupon->id)->where('user_id',auth('api')->id())->exists();

       if($coupon->end < now()){
           return response()->json([
               'success' => false,
               'message' => 'Coupon has been expired'
           ], 200);
        }elseif($coupon->start > now()){
           return response()->json([
               'success' => false,
               'message' => 'Coupon is not eligible now'
           ], 200);
        }elseif($coupon->qty <= $usage->count()){
           return response()->json([
               'success' => false,
               'message' => 'Coupon has exceeded usage limit'
           ], 200);
        }elseif($exists){
           return response()->json([
               'success' => false,
               'message' => 'You have already used this coupon'
           ], 200);
        }else {
            return response()->json([
                'success' => true,
                'message' => 'Code Verification Successful!'
            ], 200);
        }
    }

    public function applyCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required'
        ]);

        $coupon = Coupon::query()
            ->where('code', $request->code)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry! No Coupon found!'
            ], 200);
        }
        $usage = CouponUsage::query()->where('coupon_id',$coupon->id)->get();
        $exists = CouponUsage::query()->where('coupon_id',$coupon->id)->where('user_id',auth('api')->id())->exists();

        if($coupon->end < now()){
            return response()->json([
                'success' => false,
                'message' => 'Coupon has been expired'
            ], 200);
        }elseif($coupon->start > now()){
            return response()->json([
                'success' => false,
                'message' => 'Coupon is not eligible now'
            ], 200);
        }elseif($coupon->qty <= $usage->count()){
            return response()->json([
                'success' => false,
                'message' => 'Coupon has exceeded usage limit'
            ], 200);
        }elseif($exists){
            return response()->json([
                'success' => false,
                'message' => 'You have already used this coupon'
            ], 200);
        }else {
            return response()->json([
                'success' => true,
                'message' => 'Code Verification Successful!'
            ], 200);
        }
    }

}
