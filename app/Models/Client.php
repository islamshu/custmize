<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    public function favorites() {
        return $this->belongsToMany(Product::class, 'favorites', 'client_id', 'product_id')->withTimestamps();
    }
    
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];
}
