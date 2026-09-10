<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wholesale extends Model
{
    use HasFactory;

    protected $fillable= ['product_id','min_range','max_range','price','status'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');

    }
}
