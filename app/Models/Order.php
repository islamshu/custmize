<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'total_amount',
        'subtotal',
        'discount_amount',
        'promo_code',
        'status',
        'name',
        'email',
        'code',
        'client_id',
        'shipping',
        'phone',
        'full_request'
    ];
    public function shipping_info()
    {
        return $this->hasOne(Shipping::class);
    }


    // Relationship with OrderDetail
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function OrderStatus()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    
}
