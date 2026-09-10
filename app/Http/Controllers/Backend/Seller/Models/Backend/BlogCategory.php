<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','status'];

    public function blogs()
    {
        return $this->hasMany(Blog::class,'blog_category_id');
    }

}
