<?php

namespace App\Models\Backend;

use App\Models\Frontend\BlogComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable =['blog_category_id','title','slug','description','tag','image','status','user_id'];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class,'blog_category_id');
    }

    public function user()
    {
        return $this->belongsTo(Admin::class,'user_id');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class,'blog_id');
    }
}
