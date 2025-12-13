<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'description',
        'price',
        'discount_price',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Do‘kon
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // Kategoriya
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Rasmlar (gallery)
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Videolar
    public function videos()
    {
        return $this->hasMany(ProductVideo::class);
    }

    // Variantlar (rang, o‘lcham)
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Atributlar (masalan: material, brend)
    public function attributes()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values')
                    ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // Faqat aktiv mahsulotlar
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Chegirmali mahsulotlar
    public function scopeDiscounted($query)
    {
        return $query->whereNotNull('discount_price')
                     ->where('discount_price', '<', \DB::raw('price'));
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    // Asosiy rasm
    public function getMainImageAttribute()
    {
        return $this->images()->first()?->url ?? null;
    }

    // Amaldagi narx (chegirma bo‘lsa uni qaytaradi)
    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    // Omborda mavjudligi
    public function getInStockAttribute()
    {
        if ($this->variants()->count() > 0) {
            return $this->variants()->sum('stock') > 0;
        }
        return true;
    }
}
