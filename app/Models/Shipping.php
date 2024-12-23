<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'receiver_name','receiver_phone','receiver_email', 'address', 'city', 'postal_code', 'country', 'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
