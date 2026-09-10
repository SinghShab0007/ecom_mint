<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\ShippingAddress;
use Illuminate\Http\Request;

class ShippingAddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function store(Request $request)
    {
        $user_id = auth('customer')->id();
        $address = ShippingAddress::where('user_id', $user_id)->latest()->first();

        $indiaCountryId = \App\Models\Backend\Country::query()
            ->where('iso_no', 'IN')
            ->orWhere('name', 'India')
            ->orWhere('nick_name', 'India')
            ->value('id');

        $data = [
            "user_id" => $user_id,
            "shipping_name" => $request->first_name,
            "address_line_one" => $request->shipping_address,
            "address_line_two" => $request->shipping_address_2,
            "shipping_mobile" => $request->mobile,
            "shipping_post" => $request->shipping_pincode,
            "shipping_town" => $request->shipping_city,
            "shipping_country_id" => $indiaCountryId,
            "note" => 'State: ' . ($request->shipping_state ?? '') . ' | District: ' . ($request->shipping_district ?? ''),
        ];
        if(!$address){
            ShippingAddress::query()->create($data);
        } else {
            $address->update($data);
        }
    }
}
