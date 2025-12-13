<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_type',       // yuridik yoki YATT
        'company_name',        // Kompaniya yoki YATT nomi
        'tin',                 // STIR (unique)
        'license_number',      // Litsenziya raqami
        'license_document',    // Litsenziya fayli
        'store_name',          // Do‘kon nomi
        'phone',               // Majburiy telefon raqam
        'address',
        'balance',
        'status',              // pending | approved | rejected
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Seller -> User (bir seller bitta userga tegishli)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Seller -> Stores (bitta seller bir nechta do‘kon ochishi mumkin)
    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    // Seller -> Products (seller qo‘shgan barcha mahsulotlar)
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Seller -> Orders (do‘koni orqali qilingan barcha buyurtmalar)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    // Seller aktiv (tasdiqlangan) yoki yo‘q
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
