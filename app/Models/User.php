<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'role',
        'avatar',
        'address',
        'city',
        'country',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // 🔗 Agar user seller bo‘lsa → seller ma’lumotlari
    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    // 🔗 Userga tegishli do‘konlar (ko‘p do‘kon ochishi mumkin)
    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    // 🔗 User buyurtmalari
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    // 🔑 User roli tekshirish
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSeller()
    {
        return $this->role === 'seller';
    }

    public function isCustomer()
    {
        return $this->role === 'user' || $this->role === 'customer';
    }

    // 🔑 Foydalanuvchi aktiv yoki bloklangan
    public function isActive()
    {
        return $this->is_active === true;
    }
}
