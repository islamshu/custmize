<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;
    protected $table ="product_colors";
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Define the relationship with the Color
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
