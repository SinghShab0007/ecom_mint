<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqSubCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'faq_category_id','name','order','slug','is_active'
    ];

    public function category(): HasOne {
        return $this->hasOne(FaqCategory::class,'id','faq_category_id');
    }
}
