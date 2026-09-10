<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:seller');
    }

    public function index(Request $request)
    {

        $c = Category::query()->where('is_active',1);

        if($request->has('q')){
            $c->where('name','like','%'.$request->q.'%');
        }

        $categories = $c->paginate(50);

        return view('seller.category.index',compact('categories'));
    }
}
