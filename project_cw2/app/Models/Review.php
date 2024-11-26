<?php

// app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['product_id', 'rating', 'review', 'name', 'email'];

    // Nếu có quan hệ với bảng products, bạn có thể định nghĩa phương thức quan hệ ở đây
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
