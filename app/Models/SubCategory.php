<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function types()
    {
        return $this->hasMany(related: CategoryTypes::class);
    }
    

    
}
