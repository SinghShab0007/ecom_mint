<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
    ];
    protected $hidden = ['created_at','deleted_at','updated_at'];
    /**
     * A category has one parent
     *
     * @return HasOne
     */
    public function parents(): HasOne
    {
        return $this->hasOne(Category::class);
    }

    /**
     * A category has many products
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'category_id');
    }

    /**
     * A category has many categories
     *
     * @return HasMany
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(Category::class)->orderBy('order');
    }

    /**
     * A category has many brands
     *
     * @return HasMany
     */
    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class,'cat_id');
    }

    public function getIconAttribute(): string
    {
        return URL::to('uploads/categories/32x32'). '/' . $this->attributes['icon'];
    }

    public function getBannerAttribute(): string
    {
        return URL::to('uploads/categories/200x200'). '/' . $this->attributes['banner'];
    }
}
