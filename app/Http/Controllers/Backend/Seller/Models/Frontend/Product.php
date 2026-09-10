<?php

namespace App\Models\Frontend;

use App\Models\Backend\Wholesale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Modules\Backend\ProductManagement\Entities\ProductVideo;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'total_viewed','quantity'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active',1)->where('publish_stat',2);
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
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

    public function video()
    {
        return $this->hasOne(ProductVideo::class, 'product_id', 'id');
    }

    /**
     * A product has many images
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->where('deleted_at',null);
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
        return $this->hasMany(ProductReview::class)->where('publish_stat',1);
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

    public function productstock()
    {
        return $this->hasMany(App\Models\Productstock::class);
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

    /**
     * A product is belongs to many sizes
     *
     * @return HasMany
     */
    public function wholesales(): HasMany
    {
        return $this->hasMany(Wholesale::class,'product_id');
    }

    protected $casts = [
        'courieres' => 'json',
    ];
}
