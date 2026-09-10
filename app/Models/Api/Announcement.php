<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Announcement extends Model
{
    use HasFactory;

    public function getThumbnailAttribute() : string
    {
        return URL::to('/uploads/announcements'). '/' .$this->attributes['thumbnail'];
    }
}
