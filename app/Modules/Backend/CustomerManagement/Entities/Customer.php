<?php

namespace App\Modules\Backend\CustomerManagement\Entities;

use App\Models\Backend\Country;
use App\Modules\Backend\OrderManagement\Entities\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'users';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'first_name', 'last_name', 'email', 'address', 'mobile', 'gender', 'username', 'password', 'country_id','stop_email',
        'image','is_active', 'is_approve', 'email_verified_at','dob','is_suspended','verification_code','verification_expire_at',
        'last_login_datetime',
    ];

    public function full_name()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id')->withDefault(['name' => '']);
    }
    /*
     *  scope for suspended customer
     */
    public function scopeSuspended($query)
    {
        return $query->where('is_suspended', 1);
    }

    /**
     * Scope a query to only include active customer.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

}
