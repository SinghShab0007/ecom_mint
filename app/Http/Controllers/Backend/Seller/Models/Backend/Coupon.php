<?php

namespace App\Models\Backend;

use App\Models\Frontend\CouponUsage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['start','end'];

    protected $fillable = ['type','code','details','qty','discount','discount_type','start','end'];

    /**
     * A coupon has many usage
     *
     * @return HasMany
     */
    public function usage(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }
}
