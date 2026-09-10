<?php

namespace App\Modules\Backend\OrderManagement\Entities;

use App\Models\Backend\Country;
use App\Modules\Backend\CustomerManagement\Entities\Customer;
use App\Modules\Backend\SellerManagement\Entities\Seller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Timeline extends Model
{
    use HasFactory;

    protected $table = 'order_timelines';

    protected $fillable = [
        'order_detail_id','user_id', 'product_id', 'order_stat', 'order_stat_desc', 'order_stat_datetime', 'remarks'
    ];

    /* order status */

    public function status():HasOne
    {
        return $this->hasOne(OrderStatus::class, 'id', 'order_stat')->withDefault(['name' => '']);
    }

}
