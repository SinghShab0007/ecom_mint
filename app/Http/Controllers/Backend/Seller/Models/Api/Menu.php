<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    use HasFactory;

    protected $hidden = ['created_at','updated_at'];
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
