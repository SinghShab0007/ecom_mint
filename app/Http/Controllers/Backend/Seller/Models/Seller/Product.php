<?php

namespace App\Models\Seller;

use App\Models\Frontend\Brand;
use App\Models\Frontend\Color;
use App\Models\Frontend\Size;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category_id', 'brand_id', 'barcode', 'unit', 'minimum_qty', 'tags', 'is_refundable', 'attributes', 'unit_price', 'slug', 'sku', 'purchase_price', 'discount', 'quantity', 'description', 'pdf_specification', 'meta_title', 'meta_description', 'meta_image', 'is_active', 'publish_stat', 'created_by', 'updated_by', 'deleted_by', 'shipping_cost', 'outside_shipping_cost', 'seller_id', 'sale_price',
    ];

    /**
     * A product has many images
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->where('deleted_at', null);
    }

    /**
     * A product is belongs to a brand
     *
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * A product is belongs to many colors
     *
     * @return BelongsToMany
     */
    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class);
    }

    /**
     * A product is belongs to many sizes
     *
     * @return BelongsToMany
     */
    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class);
    }

    public function details()
    {
        return $this->hasOne(ProductDetails::class, 'product_id', 'id')->withDefault([]);
    }
    public function video()
    {
        return $this->hasOne(ProductVideo::class, 'product_id', 'id')->withDefault([]);
    }

    public function promotion()
    {
        return $this->belongsTo(PromotionalProduct::class, 'id', 'product_id')->withDefault([]);
    }

    public function wholesales()
    {
        return $this->hasMany(Wholesale::class, 'product_id');
    }
}
