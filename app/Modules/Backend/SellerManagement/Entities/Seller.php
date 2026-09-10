<?php

namespace App\Modules\Backend\SellerManagement\Entities;

use App\Modules\Backend\ProductManagement\Entities\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Seller extends Authenticatable
{
    use HasRoles, Notifiable, SoftDeletes;

    protected $guard_name = 'seller';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'company_name', 'first_name', 'last_name', 'wallet', 'slug', 'image', 'password', 'remember_token', 'address', 'post_code', 'city', 'mobile', 'email',
        'business_address', 'business_email', 'business_mobile', 'nid_no', 'passport_no', 'domain_name', 'domain_ssl_stat',
        'is_active', 'is_approve', 'is_suspended', 'gender', 'facebook', 'tin', 'banner', 'website',
        // Extended registration fields
        'category_id', 'business_type', 'gstin', 'gstin_verified_at', 'referral_code',
        'pan', 'pan_image', 'business_name', 'shop_owner_name', 'shop_manager_name', 'shop_manager_mobile',
        'shop_no_complex', 'area', 'landmark', 'district', 'state', 'country',
        'shipping_phone', 'deal_categories', 'data_consent',
        'email_verified_at', 'verification_code', 'verification_expire_at',
    ];

    protected $casts = [
        'deal_categories' => 'array',
        'data_consent' => 'boolean',
        'gstin_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    public function products():HasMany
    {
        return $this->hasMany(Product::class, 'seller_id')->where('is_active', 1);
    }

    public function full_name()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);;
    }

    protected $hidden = [
        'password', 'remember_token', 'verification_code', 'verification_expire_at'
    ];

    /**
     * Scope a query to only include active customer.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function guardName()
    {
        return 'seller';
    }

}
