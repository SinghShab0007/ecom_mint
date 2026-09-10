<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

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
        return $this->hasMany(Product::class);
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

    public function productCount()
    {
        $cats[] = $this->id;
        foreach($this->subCategories as $category){
            $cats[] = $category->id;
            foreach($category->subCategories as $category){
                $cats[] = $category->id;
            }
        }

        return Product::query()
            ->whereIn('category_id',$cats)
            ->where('is_active',1)
            ->count();
    }
}
