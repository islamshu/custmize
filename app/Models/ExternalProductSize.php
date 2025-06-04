<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalProductSize extends Model
{
    protected $fillable = ['color_id', 'name','default_code','external_id'];

    public function color()
    {
        return $this->belongsTo(ExternalProductColor::class, 'color_id');
    }
}
