<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class Brand extends Model
{
    use SoftDeletes;

    protected $hidden = ['created_at','deleted_at','updated_at'];
    protected $fillable = [
        'name','sort','status','image','url','alias'
    ];

    public function scopeActive($query)
    {
        return $this->where('is_active',1);
    }

    /**
     * A brand has many products
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'brand_id');
    }

    public function getImageAttribute(): string
    {
        return URL::to('uploads/brands/120x80'). '/' . $this->attributes['image'];
    }
}
