<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ResponseMessage;
use App\Models\Api\Country;
use App\Models\Api\OrderDetail;
use App\Models\Api\ShippingAddress;
use App\Models\Api\User;
use App\Models\Api\UserBilling;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    use ApiResponse, ResponseMessage;

    public function __construct()
    {

    }

    public function index()
    {
        $url = config('constants.image_base_path') . '/orders.json';

        //  Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        // Execute
        $result = curl_exec($ch);
        // Closing
        curl_close($ch);

        $allOrders = json_decode($result, true);
        $pending = json_decode($result, true);
        return view('customer.pages.order', compact('allOrders', 'pending'));
    }

    public function profile(): JsonResponse
    {
        try {
            $customer = auth('api')->user()->apiUserResponse();
            $orders = OrderDetail::query()->where('user_id', auth('api')->id())->get();
            $shipping = ShippingAddress::query()->with('country')->where('user_id', auth('api')->id())->latest()->first();
            $billing = UserBilling::query()->where('user_id', auth('api')->id())->latest()->first();
            $country = $billing->country;
            if ($billing == null) {
                $billing = new UserBilling;
            }

            if ($shipping == null) {
                $shipping = new ShippingAddress;
            }

            return $this->successResponse(compact('customer', 'orders', 'billing', 'shipping', 'country'), $this->load_success['message']);

        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }


    }

    public function getBilling(): JsonResponse
    {
        try {
            $billing = UserBilling::query()->with('country')->where('user_id', auth('api')->id())->latest()->first();
            if($billing){
                return $this->successResponse($billing, $this->load_success['message']);
            }else{
                return $this->successResponse('', $this->not_found_message['message']);
            }

        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }


    }
    public function getShipping(): JsonResponse
    {
        try {
            $shipping = ShippingAddress::query()->with('country')->where('user_id', auth('api')->id())->latest()->first();
            if($shipping){
                return $this->successResponse($shipping, $this->load_success['message']);
            }else{
                return $this->successResponse('', $this->not_found_message['message']);
            }

        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }


    }



    /**
     * Update user's information
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request): JsonResponse
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required|numeric|unique:users,mobile,'.auth('api')->id(),
            'dob' => 'required|date',
            'gender' => 'required'
        ]);
        try {
            $user = auth('api')->user();
            $user->update($request->all());
            return $this->successResponse($user->apiUserResponse(), 'Profile has been updated');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }

    }

    /**
     * Update user's default billing information
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function billing(Request $request): JsonResponse
    {
        $this->validate($request, [
            'address_1' => 'required',
            'user_city' => 'required',
            'mobile' => 'required|numeric',
            'post_code' => 'required|max:5',
        ]);
        try {
            $user = auth('api')->user();
            $request['user_id'] = $user->id;
            $request['first_name'] = $user->first_name;
            $request['last_name'] = $user->last_name;

            $billing = UserBilling::updateOrCreate(
                ['user_id' => $user->id],
                $request->all()
            );

            return $this->successResponse($billing, 'Billing address has been updated');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }
    }

    /**
     * Update user's default shipping address
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function shipping(Request $request): JsonResponse
    {
        $this->validate($request, [
            "shipping_name" => 'required',
            "address_line_one" => 'required',
            "address_line_two" => 'required',
            "shipping_post" => 'required',
            "shipping_town" => 'required',
            "shipping_country_id" => 'required',
        ]);
        try {
            $user = auth('api')->user();
            $request['user_id'] = $user->id;

            $shipping = ShippingAddress::updateOrCreate(
                ['user_id' => $user->id],
                $request->all()
            );
            return $this->successResponse($shipping, 'Shipping address has been updated');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }
    }

    /**
     * Update user's avatar
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function image(Request $request): JsonResponse
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,png,bmp,tiff |max:4096'
        ]);
        try {
            $user = auth('api')->user();
            $image = $request->file('image');
            $data = [];
            $image = now()->format('YmdHis') . $user->id . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('frontend/img/users'), $image);
            $data['image'] = $image;

            $oldImage = $user->image;
            $pathinfo = pathinfo($oldImage);
            if(isset($pathinfo['extension'])) {
                File::delete(public_path('frontend/img/users/') . $pathinfo['filename'] . '.' . $pathinfo['extension']);
            }
            $user->update($data);

            return $this->successResponse($user->image, 'Image has been updated');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }

    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);
        try {
            $user = User::query()->find(auth('api')->id());

            if (Hash::check($request->old_password, $user->password)) {
                $user->update(['password' => bcrypt($request->password)]);
            } else {
                return response()->json([
                    'error' => 'Password mismatch',
                    'success' => false,
                ], 422);
            }
            return $this->successResponse('', 'Password has been updated');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }
    }

}
