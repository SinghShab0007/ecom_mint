<?php

namespace App\Modules\Backend\ProductManagement\Entities;

use App\Models\Backend\Color;
use App\Models\Backend\ProductReview;
use App\Models\Backend\Size;
use App\Models\Backend\Wholesale;
use App\Modules\Backend\OrderManagement\Entities\OrderDetail;
use App\Modules\Backend\PromotionManagement\Entities\PromotionalProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'category_id', 'brand_id', 'barcode', 'unit', 'minimum_qty', 'tags', 'is_refundable', 'attributes', 'unit_price', 'slug', 'sku', 'purchase_price', 'discount', 'quantity', 'description', 'pdf_specification', 'meta_title', 'meta_description', 'meta_image', 'is_active', 'publish_stat', 'created_by', 'updated_by', 'deleted_by', 'shipping_cost', 'outside_shipping_cost', 'seller_id', 'sale_price', 'warranty', 'return_policy',
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id')->withDefault([]);
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id')->withDefault([

        ]);
    }
    public function colors()
    {
        return $this->belongsToMany(Color::class)
            ->withTimestamps();
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class)
            ->withTimestamps();
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
    public function details()
    {
        return $this->hasOne(ProductDetail::class, 'product_id', 'id')->withDefault([

        ]);
    }
    public function video()
    {
        return $this->hasOne(ProductVideo::class, 'product_id', 'id')->withDefault([]);
    }
    public function promotion()
    {
        return $this->belongsTo(PromotionalProduct::class, 'id', 'product_id')->withDefault([]);
    }
    public function review()
    {
        return $this->belongsTo(ProductReview::class, 'id', 'product_id')->withDefault([]);
    }
    public function orders()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function wholesales()
    {
        return $this->hasMany(Wholesale::class, 'product_id');
    }
}
