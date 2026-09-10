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

    protected $guarded = [];

    protected $casts = [
        'deal_categories' => 'array',
        'data_consent' => 'boolean',
        'gstin_verified_at' => 'datetime',
    ];

    protected $hidden = [
        'password', 'remember_token', 'verification_code', 'verification_expire_at'
    ];
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
