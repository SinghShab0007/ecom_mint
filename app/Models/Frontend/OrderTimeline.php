<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTimeline extends Model
{
    use HasFactory;

    protected $dates = ['order_stat_datetime'];

    protected $fillable = ['order_detail_id','user_id','order_stat','order_stat_desc','order_stat_datetime','remarks','product_id'];

    /**
     * A timeline is belongs to an order state
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class,'order_stat');
    }
}
