<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class SubCategory extends Model
{
    use HasFactory;
    public function getNameAttribute()
    {
        return App::getLocale() === 'ar' ? $this->attributes['name_ar'] : $this->attributes['name'];
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function types()
    {
        return $this->hasMany(related: CategoryTypes::class);
    }
    

    
}
