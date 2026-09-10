<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ResponseMessage;
use App\Models\Api\Brand;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
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
        $brands = Brand::query()
            ->active()
            ->orderBy('order')
            ->orderBy('name')
            ->paginate(request('per_page',20));
        return $this->successResponse($brands,'');
    }

    public function show($id):JsonResponse
    {
        $brand = Brand::active()->find($id);
        if($brand)
            return $this->successResponse($brand,'');
        else
            return $this->successResponse('','Not Found');
    }
}
