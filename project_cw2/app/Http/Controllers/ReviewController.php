<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Hiển thị trang review cho sản phẩm với tất cả các đánh giá
    public function index($productId)
    {
        // Lấy tất cả các đánh giá của sản phẩm có productId
        $reviews = Review::where('product_id', $productId)->get();

        // Trả về view với biến reviews
        return view('products.content', compact('reviews')); 
    }

    // Lưu đánh giá vào cơ sở dữ liệu
    public function store(Request $request, $productId)
    {
        // Validate input
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        // Lưu đánh giá vào cơ sở dữ liệu
        $review = new Review();
        $review->product_id = $productId; // Gán product_id cho review
        $review->rating = $validated['rating'];
        $review->review = $validated['review'];
        $review->name = $validated['name'];
        $review->email = $validated['email'];
        $review->save();

        // Sau khi lưu thành công, chuyển hướng lại trang review của sản phẩm
        return redirect()->route('reviews.index', $productId)->with('success', 'Your review has been submitted successfully.');
    }
}
