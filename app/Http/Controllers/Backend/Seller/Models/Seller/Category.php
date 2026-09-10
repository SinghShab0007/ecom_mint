<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    /**
     * A category has one parents
     *
     * @return BelongsTo
     */
    public function parents(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
