<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerUser extends Authenticatable
{
    use HasFactory;
    protected $guard = 'customer';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'customer_id', 'id');
    }

}
