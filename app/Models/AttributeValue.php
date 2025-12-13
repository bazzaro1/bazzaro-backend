<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id',
        'value',
        'color_code',
    ];

    // 🔗 AttributeValue -> attribute
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    // 🔗 AttributeValue -> products (many-to-many)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute_values')
                    ->withTimestamps();
    }

    // 🔗 AttributeValue -> variants
    public function variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_attributes')
                    ->withTimestamps();
    }
}
