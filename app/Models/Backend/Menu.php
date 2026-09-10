<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'name','url','target','is_header_menu','is_footer_menu','is_quick_link',
        'is_informatics', 'is_active'
    ];
    public function page():HasOne {
        return $this->hasOne(Page::class,'menu_id','id')->withDefault([]);
    }
}
