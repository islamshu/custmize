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
    ];

    // Relationship with OrderDetail
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function client()
{
    return $this->belongsTo(Client::class, 'client_id');
}
}
