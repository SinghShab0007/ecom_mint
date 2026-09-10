<?php
/**
 * Created by PhpStorm.
 * User: SSE
 * Date: 2/24/2019
 * Time: 3:17 PM
 */

namespace App\Http\Traits;


use App\Models\Brand;
use App\Models\Category;
use App\Models\Manufacture;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\ProductSale;
use App\Models\ProductStore;
use App\Models\SubCategory;
use App\Models\Supplier;
use App\Models\Unit;

Trait CommonDb
{
    public function categories()
    {
        return Category::orderBy('name', 'asc')->get();
    }

    public function subCategories()
    {
        return SubCategory::orderBy('name', 'asc')->get();
    }

    public function units()
    {
        return Unit::orderBy('name', 'asc')->get();
    }

    public function brands()
    {
        return Brand::orderBy('name', 'asc')->get();
    }

    public function models()
    {
        return ProductModel::orderBy('name', 'asc')->get();
    }

    public function manufacturers()
    {
        return Manufacture::orderBy('name', 'asc')->get();
    }

    public function suppliers()
    {
        return Supplier::orderBy('name', 'asc')->get();
    }

    public function products()
    {
        return Product::orderBy('name', 'asc')->get();
    }
    public function store_products($store_id)
    {
        return Product::with('store')->whereHas('store', function ($query) use ($store_id){
            $query->where('store_id',$store_id);
        })
        ->orderBy('name', 'asc')->paginate(15);
    }

    public function selectedProducts($sale)
    {
        $selected_items = (Object)[];
        $ids = array();
        $texts = array();
        $codes = array();
        $unit_price = array();
        $sale_price = array();
        $quantities = array();
        $max_quantity = array();
        $sub_total = array();
        $vat = array();
        $vat_total = array();
        $discount = array();
        $discount_type = array();
        $discount_total = array();

        if (isset($sale->products)) {
            foreach ($sale->products as $product) {

                $present_quantity = ProductStore::where('store_id', $sale->id)->where('product_id', $product->id)->pluck('present_quantity');
                $product_sale = ProductSale::with('discount')->where('product_id', $product->id)
                    ->where('sale_id', $sale->id)->first();

                array_push($ids, $product->id);
                array_push($texts, $product->name);
                array_push($codes, $product->code);
                array_push($unit_price, $product->pivot->unit_price);
                array_push($sale_price, $product->pivot->sale_price);
                array_push($quantities, $product->pivot->quantity);
                array_push($max_quantity, $present_quantity->first());
                array_push($sub_total, $product->pivot->sub_total);
                array_push($vat, $product->pivot->vat);
                array_push($vat_total, $product->pivot->vat_amount);
                array_push($discount, $product_sale->discount->amount);
                array_push($discount_type, $product_sale->discount->type);
                array_push($discount_total, $product->pivot->discount_amount);
            }
            $selected_items->ids = $ids;
            $selected_items->texts = $texts;
            $selected_items->codes = $codes;
            $selected_items->unit_price = $unit_price;
            $selected_items->sale_price = $sale_price;
            $selected_items->sub_total = $sub_total;
            $selected_items->quantities = $quantities;
            $selected_items->max_quantity = $max_quantity;
            $selected_items->vat = $vat;
            $selected_items->vat_total = $vat_total;
            $selected_items->discount = $discount;
            $selected_items->discount_type = $discount_type;
            $selected_items->discount_total = $discount_total;
        }
        return $selected_items;
    }
}