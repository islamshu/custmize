<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'color',
        'color_id',
        'size',
        'size_id',
        'quantity',
        'price_without_size_color',
        'price_for_size_color',
        'full_price',
        'front_image',
        'back_image',
        'logos',
    ];

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
