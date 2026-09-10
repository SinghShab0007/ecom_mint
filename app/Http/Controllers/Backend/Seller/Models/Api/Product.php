<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class Product extends Model
{
    use SoftDeletes;

    protected $hidden = ['created_at', 'deleted_at', 'updated_at'];

    protected $appends = ['is_wishlisted'];

    protected $fillable = [
        'total_viewed', 'quantity'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1)->where('publish_stat', 2);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, "product_id")->where('user_id', auth('api')->id())->count();
    }

    protected function getIsWishlistedAttribute()
    {
        return $this->hasMany(Wishlist::class, "product_id")->count() > 0 ? true : false;
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    /**
     * A product has many images
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * A product has one details
     *
     * @return HasOne
     */
    public function details(): HasOne
    {
        return $this->hasOne(ProductDetails::class);
    }

    /**
     * A product has many reviews
     *
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class)->where('publish_stat', 1);
    }

    /**
     * A product has many promotions
     *
     * @return HasMany
     */
    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class);
    }

    /**
     * A product is belongs to a seller
     *
     * @return BelongsTo
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
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

    public function getAttributesAttribute()
    {
        if ($this->attributes['attributes'] != null)
            return  json_decode($this->attributes['attributes']);
        else
            return '';
    }

    public function getPdfSpecificationAttribute(): string
    {
        if ($this->attributes['pdf_specification'] != null)
            return URL::to('uploads/products/pdf') . '/' . $this->attributes['pdf_specification'];
        else
            return '';
    }

    public function getMetaImageAttribute(): string
    {
        if ($this->attributes['meta_image'] != null)
            return URL::to('uploads/products/meta_image') . '/' . $this->attributes['meta_image'];
        else
            return '';
    }
}
