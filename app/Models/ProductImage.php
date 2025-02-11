<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_detail_id', // Add this field
        'front_images',
        'back_images',
        'right_side',
        'left_side',
    ];

    protected $casts = [
        'front_images' => 'array',
        'back_images' => 'array',
        'right_side' => 'array',
        'left_side' => 'array',
    ];

    // Define the relationship with OrderDetail
    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'order_detail_id');
    }
}