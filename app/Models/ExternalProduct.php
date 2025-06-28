<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalProduct extends Model
{
    protected $fillable = [
        'external_id',
        'name',
        'description_sale',
        'image_url',
        'brand',
        'default_codes',
        'product_ids',
        'image',
        'product_prices',
        'price',
        'subcategory_id'

    ];

    protected $attributes = [
        'product_ids' => '[]' // تعيين القيمة الافتراضية داخل الـ Model
    ];

    protected $casts = [
        'default_codes' => 'array', // تحويل إلى Array تلقائيًا
        'product_ids' => 'array',
        'product_prices' => 'array', // ✅ Add this

    ];

    public function colors()
    {
        return $this->hasMany(ExternalProductColor::class, 'external_product_id');
    }
    public function getMinPrice(): ?float
    {
        if (empty($this->product_prices)) return null;

        return min(array_values($this->product_prices));
    }

    public function getMaxPrice(): ?float
    {
        if (empty($this->product_prices)) return null;

        return max(array_values($this->product_prices));
    }
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }   
}
