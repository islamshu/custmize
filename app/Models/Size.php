<?php

// في ملف: app/Models/Size.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['name','name_ar'];
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
    

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
