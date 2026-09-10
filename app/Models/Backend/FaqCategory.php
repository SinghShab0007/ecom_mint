<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name','order','slug','is_active','icon'
    ];

    public function subcategories(): HasMany{
        return $this->hasMany(FaqSubCategory::class,'faq_category_id');
    }
}
