<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'name', 'price', 'quantity', 'attributes', 'front_image', 'front_design'];

    protected $casts = [
        'attributes' => 'array', // Cast the attributes JSON field to array
    ];
}
