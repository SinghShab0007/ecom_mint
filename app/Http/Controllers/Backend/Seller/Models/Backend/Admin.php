<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'remember_token',
        'is_active',
        'verification_code',
        'verification_expire_at',
    ];

    protected $hidden = [
        'password', 'remember_token', 'verification_code', 'verification_expire_at'
    ];
}
