<?php

namespace App\Models;

use App\Models\Frontend\Color;
use App\Models\Frontend\Size;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productstock extends Model
{
    use HasFactory;

    protected $fillable = [
        'size_id',
        'color_id',
        'product_id',
        'quantities',
    ];

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
