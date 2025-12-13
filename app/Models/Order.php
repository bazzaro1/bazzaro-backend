<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'buyer_name',
        'buyer_phone',
        'buyer_address',
        'quantity',
        'total_price',
        'payment_method',
        'payment_status',
        'status',
        'credit_contract_number',
        'credit_bank',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // 🔗 Do‘kon (sotuvchi)
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // 🔗 Buyurtma ichidagi mahsulotlar
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    // Buyurtmaning jami mahsulot soni
    public function totalQuantity()
    {
        return $this->items()->sum('quantity');
    }

    // Buyurtmaning yakuniy summasi (agar itemlar bo‘yicha hisoblash kerak bo‘lsa)
    public function finalTotal()
    {
        return $this->items()->sum('total');
    }

    // Kredit bilanmi yoki oddiy to‘lovmi tekshirish
    public function isCredit()
    {
        return !empty($this->credit_contract_number);
    }
}
