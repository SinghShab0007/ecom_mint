<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory,Notifiable,HasApiTokens;

    protected $dates = ['last_login_datetime','dob'];

    protected $fillable = ['first_name','last_name','address','mobile','email','image','username','password','gender','dob','stop_email','is_approve','is_suspended','verification_code','verification_expire_at','last_login_datetime','is_active'];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword(): string
    {
        return $this->password;
    }

    /**
     * A user has one shipping address
     *
     * @return HasOne
     */
    public function shipping(): HasOne
    {
        return $this->hasOne(ShippingAddress::class)->latestOfMany();
    }

    /**
     * A user has one billing address
     *
     * @return HasOne
     */
    public function billing(): HasOne
    {
        return $this->hasOne(UserBilling::class)->latestOfMany();
    }

    public function apiUserResponse(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'mobile' => $this->mobile,
            'username' => $this->username,
            'email' => $this->email,
//            'image' => $this->image,
            'gender' => $this->gender,
            'dob' => $this->dob,
        ];
    }
}
