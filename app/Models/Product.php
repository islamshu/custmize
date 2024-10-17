<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_type_id', 'name', 'description', 'price'];

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function favorites()
{
    return $this->belongsToMany(Client::class, 'favorites', 'product_id', 'client_id');
}
    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }
    public function pen()
    {
        return $this->hasOne(Pen::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }
    /**
     * Get the user that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }
    
}