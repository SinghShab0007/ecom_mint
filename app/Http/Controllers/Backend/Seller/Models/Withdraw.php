<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Backend\SellerManagement\Entities\Seller;

class Withdraw extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'trx_id',
        'seller_id',
        'status',
        'bank_name',
        'bank_branch',
        'account_holder',
        'account',
        'account_type',
        'routing_number',
        'swift_code',
        'amount',
        'note',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}
