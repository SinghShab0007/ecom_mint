<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ResponseMessage;
use App\Models\Api\Announcement;
use App\Models\Api\Banner;
use App\Models\Api\Category;
use App\Models\Api\FAQ;
use App\Models\Api\Menu;
use App\Models\Api\Product;
use Illuminate\Http\JsonResponse;

class WebsiteController extends Controller
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
    public function page($url) :JsonResponse
    {
        $menu = Menu::query()->where('url','like','%'.$url.'%')->first();

        $page = $menu->page;
        if($page){
            return $this->successResponse($page,$this->load_success['message']);
        }else{
            return $this->successResponse('',$this->not_found_message['message']);
        }
    }

    public function banners() :JsonResponse
    {
        $banners = Banner::query()
            ->where('is_active',1)
            ->where('publish_stat',1)
            ->where(function($q){
                $q->where('expire_at','>',now())->orWhere('expire_at',null);
            })
            ->orderByDesc('id')
            ->limit(5)
            ->get();
        if(count($banners)){
            return $this->successResponse($banners,$this->load_success['message']);
        }else{
            return $this->successResponse('',$this->not_found_message['message']);
        }
    }

    public function faq(): JsonResponse
    {
        $faqs = FAQ::query()->where('is_active',1)->paginate(request('per_page',10));
        return $this->successResponse($faqs,$this->load_success['message']);
    }

    public function announcements(): JsonResponse
    {
        $announcements = Announcement::query()
            ->where('is_active',1)
            ->where('expire_at','>',now())
            ->get();
        return $this->successResponse($announcements,$this->load_success['message']);
    }

    public function home():JsonResponse
    {
        $categories = Category::orderBy('order')->where('is_active',1)->where('category_id',NULL)->orderBy('name')->paginate(request('per_page',20));
        $banners = Banner::query()
            ->where('is_active',1)
            ->where('publish_stat',1)
            ->where(function($q){
                $q->where('expire_at','>',now())->orWhere('expire_at',null);
            })
            ->orderByDesc('id')
            ->limit(5)
            ->get();
        $flash_sale = Product::query()
            ->with('images','details','category','brand')
            ->where('discount', '>' , 0)
            ->orderBy('discount', 'DESC')
            ->active()
            ->inRandomOrder()
            ->take(3)
            ->get();
        $trends_products = Product::query()
            ->with('images','details','category','brand')
            ->active()
            ->orderByDesc('total_viewed')
            ->take(6)
            ->get();
        $popular_products = Product::query()
            ->with('images','details','category','brand')
            ->inRandomOrder()
            ->take(6)
            ->get();
        $data = (object)[];
        $data->category = $categories;
        $data->banners = $banners;
        $data->flash_sale = $flash_sale;
        $data->trends_products = $trends_products;
        $data->popular_products = $popular_products;

        return $this->successResponse($data,$this->load_success['message']);
    }
}
