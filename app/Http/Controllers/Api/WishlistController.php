<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ResponseMessage;
use App\Models\Api\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class WishlistController extends Controller
{
    use ApiResponse,ResponseMessage;

    public function index()
    {
        $wishlists = Wishlist::with('product','product.images')
            ->where('user_id',auth('api')->id())
            ->paginate(request('per_page',20));
        return $this->successResponse($wishlists,$this->load_success['message']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => ['required',
                Rule::unique('wishlist','product_id')
                    ->where('user_id', auth('api')->id())
            ]
        ]);
        try {
            $data = [
                'user_id' => auth('api')->id(),
                'product_id' => intval($request->input('product_id')),
            ];
            $wish = Wishlist::query()->create($data);

            $wishlist = Wishlist::with('product','product.images')->where('user_id', auth('api')->id());
            $wishlist_count = $wishlist->count();
            $wishlist = $wishlist->get();
            return $this->successResponse(compact('wishlist','wishlist_count'),$this->create_success_message['message'],Response::HTTP_CREATED);
        }catch (\Exception $ex){
            return $this->errorResponse($ex->getMessage());
        }

    }


    public function removeFromWishlist(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $id = $request->input('id');
        $wish = Wishlist::query()->find($id);
        if($wish){
            $wish->delete();
            $wishlists = Wishlist::with('product','product.images')
                ->where('user_id',auth('api')->id())
                ->paginate(request('per_page',20));
            return $this->successResponse($wishlists,$this->delete_success_message['message']);
        }else{
            return $this->errorResponse($this->not_found_message['message']);
        }
    }
}
