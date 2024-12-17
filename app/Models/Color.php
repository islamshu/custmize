<?php

// في ملف: app/Models/Color.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Color extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'code', 'name_ar'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function sizes($productId)
    {
        return $this->belongsToMany(Size::class, 'product_sizes', 'color_id', 'size_id')
                    ->where('product_sizes.product_id', $productId) // فلترة بناءً على المنتج
                    ->withPivot(['price']); // البيانات الإضافية
    }
    
}
