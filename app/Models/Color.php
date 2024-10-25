<?php

// في ملف: app/Models/Color.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Color extends Model
{
    use HasFactory;
    protected $in_edit_mode = false; // Property to check if we're in edit mode
    public function getDisplayNameAttribute()
    {
        // Check if the locale is Arabic and return the Arabic name if available
        return App::getLocale() === 'ar' ? $this->name_ar : $this->name;
    }
    
    public function useOriginalFields()
    {
        $this->in_edit_mode = true;
        return $this;
    }
    protected $fillable = ['name','code','name_ar'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

