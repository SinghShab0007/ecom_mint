<?php

namespace App\Modules\Backend\OrderManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderPayment extends Model
{
    use HasFactory;

    public $table = 'order_payments';
    protected $fillable = [
        'order_id','payment_type','card_no','card_name','tax','currency','exchange_rate'
    ];

}
