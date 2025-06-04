<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalProductColor extends Model
{
    protected $fillable = ['external_product_id', 'name', 'code','front_image','back_image','right_side_image','left_side_image','defult_price','price','default_code'];

    public function sizes()
    {
        return $this->hasMany(ExternalProductSize::class, 'color_id');
    }

    public function product()
    {
        return $this->belongsTo(ExternalProduct::class, 'external_product_id');
    }
}
