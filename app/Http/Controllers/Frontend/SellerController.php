<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Frontend\Seller;
use App\Models\Frontend\Product;
use App\Http\Controllers\Controller;
use App\Models\Frontend\ProductReview;

class SellerController extends Controller
{
    public function index($slug)
    {
        $seller = Seller::query()->where('slug',$slug)->first();
        $total_reviews = ProductReview::where('seller_id', $seller->id)->count();
        $positive = ProductReview::where('seller_id', $seller->id)->whereIn('review_point', [5, 4])->count();
        $neutral = ProductReview::where('seller_id', $seller->id)->whereIn('review_point', [2,3])->count();
        $negative = ProductReview::where('seller_id', $seller->id)->where('review_point', 1)->count();
        $ratings = ProductReview::with('user', 'product')->where('seller_id', $seller->id)->latest()->paginate();
        $total_ratings = ProductReview::where('seller_id', $seller->id)->sum('review_point');
        $average_rating = 0;
        if ($total_ratings > 0 && $total_reviews > 0) {
            $average_rating = $total_ratings / $total_reviews;
        }
        return view('frontend.seller.index', compact('seller', 'total_reviews', 'ratings', 'average_rating', 'positive', 'neutral', 'negative'));
    }

    public function product($slug)
    {
        $seller = Seller::query()->where('slug',$slug)->first();

        //$products = $seller->products->paginate(20);
        $products = Product::query()
            ->where('seller_id',$seller->id)
            ->where('is_active',1)
            ->where('publish_stat',2)
            ->paginate(20);

        return view('frontend.seller.product',compact('seller','products'));
    }
}
