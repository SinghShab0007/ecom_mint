<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id','user_id','order_id','order_stat','product_id','color','size','sale_price','qty','discount','shipping_cost','total_shipping_cost','total_price','grand_total','tax','currency_id','exchange_rate'];

    /**
     * One details is belongs to a product
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * An order details has many timeline
     *
     * @return HasMany
     */
    public function timelines(): HasMany
    {
        return $this->hasMany(OrderTimeline::class);
    }

    /**
     * An order details is belongs to an order info
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
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

    public function billing()
    {
        return $this->hasOneThrough(UserBilling::class,User::class,'user_id','user_id');
    }
}
