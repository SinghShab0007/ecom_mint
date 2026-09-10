<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ResponseMessage;
use App\Models\Frontend\Currency;
use Illuminate\Http\JsonResponse;

class CurrencyController extends Controller
{
    use ResponseMessage, ApiResponse;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index():JsonResponse
    {
        $currencies = Currency::query()
            ->where('is_active',1)
            ->orderBy('name')
            ->get();
        return $this->successResponse($currencies,$this->load_success['message']);
    }

    public function details($id):JsonResponse
    {
        $currency = Currency::where('is_active',1)->find($id);
        if($currency)
            return $this->successResponse($currency,$this->load_success['message']);
        else
            return $this->successResponse('',$this->not_found_message['message']);
    }
}
