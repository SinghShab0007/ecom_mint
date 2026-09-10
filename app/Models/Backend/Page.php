<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Page extends Model
{
    use HasFactory;

    protected $fillable=[
        'menu_id','title','description','is_active'
    ];
    public function menu():HasOne {
        return $this->hasOne(Menu::class,'menu_id','id')->withDefault([]);
    }
}
