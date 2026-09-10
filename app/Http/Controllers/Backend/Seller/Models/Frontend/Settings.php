<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'favicon',
        'vat',
        'currency_id',
        'time_zone',
        'barcode_type',
    ];

    public function discount(){
        return $this->morphOne(Discount::class, 'discountable');
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }
}
