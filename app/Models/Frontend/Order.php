<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = ['order_no','discount','coupon_discount','tax','shipping_cost','total_price','coupon_id','currency_id','exchange_rate','shipping_name','shipping_address_1','shipping_address_2','shipping_mobile','shipping_email','shipping_post','shipping_town','shipping_country_id','shipping_note','payment_by','user_id','user_first_name','user_last_name','user_address_1','user_post_code','user_city','user_country_id','user_mobile','user_email','paid_amount','meta','payment_status'];

    protected $appends = [
        'total-amount'
    ];

    protected $casts = [
        'meta' => 'json',
    ];

    /**
     * An order is belongs to a status
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class,'order_stat');
    }

    /**
     * An order is belongs to a country
     *
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class,'user_country');
    }

    /**
     * An order is belongs to a customer
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * An order has many items
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderDetail::class,'order_id');
    }
    public function getTotalAmountAttribute(){
        return $this->attributes['total_price'] + $this->attributes['shipping_cost'] -($this->attributes['coupon_discount']??0);
    }
}
