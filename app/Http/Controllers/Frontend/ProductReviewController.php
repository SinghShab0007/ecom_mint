<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Mail\ProductReviewMail;
use App\Models\Frontend\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Models\Frontend\ProductReview;

class ProductReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Store customer review in storage
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'review_point' => 'required|integer|max:5|min:1',
            'product_id' => 'required|integer|exists:products,id',
            'review_note' => 'required|string|max:1000',
        ]);

        $product = Product::with('seller')->find($request->product_id);
        $review = ProductReview::query()->create($data + [
            'user_id' => auth('customer')->id(),
            'publish_stat' => 1,
        ]);

        $options = [
            'review_point' => $review->review_point,
            'review_note' => $review->review_note,
            'user' => auth('customer')->user()->first_name .' '. auth('customer')->user()->last_name,
            'email' => auth('customer')->user()->email,
            'link' => route('product',$product->slug),
        ];

        if($product->seller->email){
            Mail::to($product->seller->email)->send(new ProductReviewMail($options));
        }

        return response()->json([
            'message' => __('Your review has been stored.'),
            'redirect' => url()->previous()
        ]);
    }
}
