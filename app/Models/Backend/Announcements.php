<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    use HasFactory;

    protected $table = 'announcements';

    protected $fillable = [
        'title','description','thumbnail','sale_price','old_price','expire_at','is_active'
    ];
}
