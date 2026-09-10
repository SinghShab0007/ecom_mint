<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    /**
     * SoftDeletes matters here for security, not just tidiness. The admin panel
     * deletes customers through CustomerManagement\Entities\Customer, which is a
     * *different* model over this same `users` table and does soft-delete. Without
     * the trait here the auth guard had no global scope on deleted_at, so a
     * "deleted" customer could still log in.
     */
    use HasFactory,Notifiable,HasApiTokens,SoftDeletes;

    protected $dates = ['last_login_datetime','dob'];

    protected $fillable = ['first_name','last_name','address','mobile','email','image','username','password','gender','dob','stop_email','is_approve','is_suspended','verification_code','verification_expire_at','last_login_datetime','is_active'];

    /**
     * Default avatar used whenever the customer has not uploaded one
     * (or their file is missing from disk).
     */
    public const DEFAULT_AVATAR = 'default.png';

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
     * Full URL of the customer's avatar, falling back to the shared default.
     *
     * @return string
     */
    public function getAvatarUrlAttribute(): string
    {
        $dir = 'frontend/img/users/';
        $file = trim((string) $this->image);

        if ($file !== '' && file_exists(public_path($dir . $file))) {
            return asset($dir . $file);
        }

        return asset($dir . self::DEFAULT_AVATAR);
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
