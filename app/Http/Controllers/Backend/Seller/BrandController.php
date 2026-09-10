<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:seller');
    }

    public function index(Request $request)
    {
        //dd($request->all());

        $b = Brand::query()->where('is_active',1);

        if($request->has('q')){
            $b->where('name','like','%'.$request->q.'%');
        }

        $brands = $b->paginate(50);

        return view('seller.brand.index',compact('brands'));
    }
}
