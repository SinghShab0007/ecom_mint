<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\UserBilling;
use Illuminate\Http\Request;

class UserBillingInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function store(Request $request)
    {
        $user_id = auth('customer')->id();
        $billing = UserBilling::where('user_id', $user_id)->latest()->first();

        $indiaCountryId = \App\Models\Backend\Country::query()
            ->where('iso_no', 'IN')
            ->orWhere('name', 'India')
            ->orWhere('nick_name', 'India')
            ->value('id');

        $address1 = trim(($request->billing_address ?? '') . ($request->billing_address_2 ? ', ' . $request->billing_address_2 : ''));

        $data = [
            'user_id' => $user_id,
            'first_name' => $request->first_name,
            'mobile' => $request->mobile,
            'address_1' => $address1,
            'post_code' => $request->billing_pincode,
            'user_city' => $request->billing_city,
            'country_id' => $indiaCountryId,
            'is_active' => 1,
        ];

        if(!$billing){
            UserBilling::create($data);
        } else {
            $billing->update($data);
        }
    }
}
