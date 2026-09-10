<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ResponseMessage;
use App\Models\Api\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
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
        $categories = Category::orderBy('order')->where('is_active',1)->where('category_id',NULL)->orderBy('name')->paginate(request('per_page',20));
        return $this->successResponse($categories,'');
    }

    public function show($id) :JsonResponse
    {
        $category = Category::where('is_active',1)->find($id);
        if($category)
            return $this->successResponse($category,'');
        else
            return $this->successResponse('','Not Found');
    }
}
