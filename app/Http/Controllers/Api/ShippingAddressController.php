<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\ShippingAddress;
use Illuminate\Http\Request;

class ShippingAddressController extends Controller
{

    public function store(Request $request)
    {
        $user_id = auth('api')->id();
        $address = ShippingAddress::query()->where('user_id',$user_id)->latest()->first();

        if(!$address){
            $data = [
                "user_id" => $user_id,
                "shipping_name" => $request->shipping_name,
                "address_line_one" => $request->address_line_one,
                "address_line_two" => $request->address_line_two??'',
                "shipping_post" => $request->shipping_post,
                "shipping_town" => $request->shipping_town,
                "shipping_country_id" => $request->shipping_country_id,
                "shipping_mobile" => $request->shipping_mobile,
                "shipping_email" => $request->shipping_email??'',
                "note" => $request->shipping_note??''
            ];

            ShippingAddress::query()->create($data);
        }
    }
}
