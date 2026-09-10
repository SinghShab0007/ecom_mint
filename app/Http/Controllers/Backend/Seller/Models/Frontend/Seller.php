<?php

namespace App\Models\Frontend;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Seller extends Authenticatable
{
    use HasFactory,Notifiable,HasApiTokens;

    protected $guarded;

    protected $hidden = ['password','remember_token'];
    /**
     * A seller has many products
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'seller_id');
    }
}
