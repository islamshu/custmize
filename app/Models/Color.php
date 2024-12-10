<?php

// في ملف: app/Models/Color.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Color extends Model
{
    use HasFactory;
 
 
    protected $fillable = ['name','code','name_ar'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

