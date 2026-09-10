<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\UserBilling;
use Illuminate\Http\Request;

class UserBillingInfoController extends Controller
{

    public function store(Request $request)
    {
        $isExists = UserBilling::query()->where('user_id',auth('api')->id())->exists();

        if(!$isExists){
            $data = [
                "user_id" => auth('api')->id(),
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "address_1" => $request->user_address_1,
                "post_code" => $request->user_post_code,
                "user_city" => $request->user_city,
                "country_id" => $request->user_country_id,
                "user_mobile" => $request->user_mobile,
                "user_email" => $request->user_email??''
            ];
            UserBilling::query()->create($data);
        }
    }
}
