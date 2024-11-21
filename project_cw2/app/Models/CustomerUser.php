<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerUser extends Model
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
