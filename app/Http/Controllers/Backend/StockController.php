<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Backend\ProductManagement\Entities\Product;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::where('is_manage_stock', 1)->latest()->paginate(10);
        return view('backend.pages.stocks.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('productstock.size', 'productstock.color')->findOrFail($id);
        return view('backend.pages.stocks.show', compact('product'));
    }
}
