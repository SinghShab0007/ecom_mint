<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ResponseMessage;
use App\Models\Api\Color;
use App\Models\Api\Product;
use App\Models\Api\Size;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
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

    /* product list */

    public function index() :JsonResponse
    {
        $products = Product::query()
            ->with('images','details','category','brand')
            ->active()
            ->paginate(request('per_page',20));

        return $this->successResponse($products, $this->load_success['message']);
    }

    /* single product */

    public function show($id) :JsonResponse
    {
        $products = Product::query()
            ->with('images','details','category','brand','productstock.color','productstock.size')
            ->active()
            ->find($id);
        if($products){
            return $this->successResponse($products, $this->load_success['message']);
        }else{
            return $this->successResponse('', $this->not_found_message['message']);
        }
    }

    /* category product list */

    public function categoryProducts($id) :JsonResponse
    {
        $products = Product::query()
            ->with('images','details','category','brand','colors','sizes')
            ->active()
            ->where('category_id',$id)
            ->paginate(request('per_page',20));

        return $this->successResponse($products, $this->load_success['message']);
    }

    /* brand product list */

    public function brandProducts($id) :JsonResponse
    {
        $products = Product::query()
            ->with('images','details','category','brand','colors','sizes')
            ->active()
            ->where('brand_id',$id)
            ->paginate(request('per_page',20));

        return $this->successResponse($products, $this->load_success['message']);
    }
 /* seller product list */

    public function sellerProducts($id) :JsonResponse
    {
        $products = Product::query()
            ->with('images','details','category','brand','colors','sizes')
            ->active()
            ->where('seller_id',$id)
            ->paginate(request('per_page',20));

        return $this->successResponse($products, $this->load_success['message']);
    }

    /* best selling products */

    public function bestSelling() :JsonResponse
    {
        $best_selling = Product::query()
            ->with('images','details','category','brand','colors','sizes')
            ->active()
            ->whereHas('details', function ($q) {
                $q->where('is_best_sell', 1);
            })
            ->inRandomOrder()
            ->take(4)
            ->get();

        return $this->successResponse($best_selling, $this->load_success['message']);
    }

    public function flashSale() :JsonResponse
    {
        $flash_sale = Product::query()
            ->with('images','details','category','brand','colors','sizes')
            ->active()
            ->whereHas('details', function ($q) {
                $q->where('flash_deal_title', '!=', NULL);
            })
            ->inRandomOrder()
            ->take(3)
            ->get();
        return $this->successResponse($flash_sale, $this->load_success['message']);
    }

    public function newArrivals(): JsonResponse
    {
        $new_arrivals = Product::query()
            ->with('images','details','category','brand','colors','sizes')
            ->active()
            ->orderByDesc('created_at')
            ->take(4)
            ->get();
        return $this->successResponse($new_arrivals, $this->load_success['message']);
    }

    public function popularProducts() :JsonResponse
    {
        $populars = Product::query()
            ->with('images','details','category','brand','colors','sizes')
            ->inRandomOrder()
            ->take(6)
            ->get();
        return $this->successResponse($populars, $this->load_success['message']);
    }
    public function trends() :JsonResponse
    {
        $products = Product::query()
            ->with('images','details','category','brand','colors','sizes')
            ->active()
            ->orderByDesc('total_viewed')
            ->paginate(request('per_page',20));
        return $this->successResponse($products, $this->load_success['message']);
    }

    public function ourFeatured() :JsonResponse
    {
        $products = Product::query()
            ->with('images','details','category','brand','colors','sizes')
            ->whereHas('details',function($q){
                $q->where('is_featured',1);
            })
            ->inRandomOrder()
            ->take(5)
            ->get();
        return $this->successResponse($products, $this->load_success['message']);
    }
    public function bestSeller() :JsonResponse
    {
        $bestSellers = Product::query()
            ->with('images','details','category','brand','colors','sizes')
            ->where('is_active',1)
            ->inRandomOrder()
            ->take(5)
            ->get();
        return $this->successResponse($bestSellers, $this->load_success['message']);
    }

    public function colors():JsonResponse
    {
        $colors = Color::query()
            ->where('is_active',1)
            ->where('display_in_search',1)
            ->get();
        return $this->successResponse($colors, $this->load_success['message']);
    }

    public function sizes():JsonResponse
    {
        $sizes = Size::query()->where('is_active',1)->get();
        return $this->successResponse($sizes, $this->load_success['message']);
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);

        $products = Product::query();

        if ($request->has('search')) {
            $searchValue = $request->get('search');
            $products
                ->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('tags', 'like', '%' . $searchValue . '%')
                ->orWhere('sku', 'like', '%' . $searchValue . '%')
                ->orWhere('sale_price', 'like', '%' . $searchValue . '%')
                ->orWhere('discount', 'like', '%' . $searchValue . '%')
                ->orWhere('description', 'like', '%' . $searchValue . '%');
        }

        $products = $products->latest()->paginate(request('per_page',20));

        return $this->successResponse($products, $this->load_success['message']);

    }


}
