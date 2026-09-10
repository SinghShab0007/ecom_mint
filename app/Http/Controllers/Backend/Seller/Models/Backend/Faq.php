<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'faq_category_id','faq_sub_category_id','question','answer','order','slug','is_active'
    ];

    public function category(): HasOne {
        return $this->hasOne(FaqCategory::class,'id','faq_category_id');
    }
    public function sub_category(): HasOne {
        return $this->hasOne(FaqSubCategory::class,'id','faq_sub_category_id');
    }
}
