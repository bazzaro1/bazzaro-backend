<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'user_id',
        'name',
        'slug',
        'status',
        'description',
        'logo',
        'banner',
        'phone',
        'address',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Do‘kon egasi (foydalanuvchi)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Do‘kon sotuvchisi
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    // Do‘kon mahsulotlari
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Do‘kon buyurtmalari
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | EVENTS
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        // Slug faqat creating paytida generatsiya qilinadi
        static::creating(function ($store) {
            if (empty($store->slug)) {
                $baseSlug = Str::slug($store->name);
                $slug = $baseSlug;
                $count = 1;

                while (Store::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }

                $store->slug = $slug;
            }
        });

        // Updating paytida slugni o‘zgartirishni cheklash
        static::updating(function ($store) {
            if ($store->isDirty('name') && !$store->isDirty('slug')) {
                $store->slug = $store->getOriginal('slug');
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isInactive()
    {
        return $this->status === 'inactive';
    }
}
