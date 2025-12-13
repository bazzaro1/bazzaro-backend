<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price',
        'discount_price',
        'stock',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // 🔗 Variant -> Mahsulot
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // 🔗 Variant -> Tanlangan atributlar (rang, o‘lcham va h.k.)
    public function attributes()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variant_attributes')
                    ->withTimestamps();
    }

    // 🔗 Variant -> Buyurtma elementlari (order_items jadvali orqali)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
