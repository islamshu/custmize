<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Client extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use HasApiTokens;
    public function favorites() {
        return $this->belongsToMany(Product::class, 'favorites', 'client_id', 'product_id')->withTimestamps();
    }
    
    protected $guarded=[];


    protected $hidden = [
        'password', 'remember_token',
    ];
}
