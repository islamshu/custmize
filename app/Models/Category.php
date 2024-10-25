<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name','image', 'parent_id','name_ar'];

    public function getNameAttribute()
    {
        return App::getLocale() === 'ar' ? $this->attributes['name_ar'] : $this->attributes['name'];
    }

    public function getDescriptionAttribute()
    {
        return App::getLocale() === 'ar' ? $this->attributes['description_ar'] : $this->attributes['description'];
    }
    // Define the relationship for subcategories (children)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Define the relationship for the parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
