<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\URL;

class Seller extends Model
{
    use HasFactory;

    protected $hidden = ['created_at','deleted_at','updated_at','password','remember_token'];

    /**
     * A seller has many products
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'seller_id');
    }

    public function getImageAttribute(): string
    {
        return URL::to('uploads/sellers'). '/' . $this->attributes['image'];
    }
}
