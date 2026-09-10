<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    use HasFactory;

    /**
     * A menu has one page
     *
     * @return HasOne
     */
    public function page(): HasOne
    {
        return $this->hasOne(Page::class,'menu_id');
    }
}
