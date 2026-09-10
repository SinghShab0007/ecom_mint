<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ResponseMessage;
use App\Models\Api\Category;
use Illuminate\Http\JsonResponse;

class SubCategoryController extends Controller
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
    public function index($id):JsonResponse
    {
        $sub_categories = Category::orderBy('order')->where('category_id',$id)->where('is_active',1)->orderBy('name')->paginate(request('per_page',20));
        return $this->successResponse($sub_categories, $this->load_success['message']);
    }

    public function show($id) :JsonResponse
    {
        $category = Category::where('is_active',1)->find($id);
        if($category)
            return $this->successResponse($category,$this->load_success['message']);
        else
            return $this->successResponse('',$this->not_found_message['message']);
    }
}
