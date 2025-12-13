<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
    ];

    /**
     * Kategoriyaning ostidagi mahsulotlar
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Kategoriyaning ota-toifasi (ko‘p darajali uchun)
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Kategoriyaning ichki toifalari (subcategories)
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
