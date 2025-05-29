<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductShow extends Model
{
    use HasFactory;
    protected $table = 'product_shows';
    public $timestamps = false;
    protected $fillable = ['product_id'];
}
