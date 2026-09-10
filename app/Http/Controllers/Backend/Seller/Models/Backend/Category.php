<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'order',
        'icon',
        'banner',
        'meta_title',
        'meta_description',
        'slug',
        'commission_rate',
        'show_in_home',
        'is_active',
    ];

    /**
     * A category has many sub-categories
     *
     * @return HasMany
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(Category::class,'category_id');
    }

    /**
     * A sub-category has many sub-sub-category
     *
     * @return HasMany
     */
    public function subSubCategories(): HasMany
    {
        return $this->hasMany(Category::class,'category_id');
    }

    /**
     * A sub-sub-category has many products
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
