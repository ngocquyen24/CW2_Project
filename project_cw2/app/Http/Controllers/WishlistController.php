<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Thêm sản phẩm vào danh sách yêu thích
    public function store($productId)
{
    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (Auth::guard('customer')->check()) {
        // Lấy người dùng hiện tại
        $userId = Auth::guard('customer')->id();

        // Kiểm tra xem sản phẩm đã có trong wishlist chưa
        $wishlist = Wishlist::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if (!$wishlist) {
            // Nếu sản phẩm chưa có trong wishlist, thêm mới
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);

            // Điều hướng và thông báo thành công
            return redirect()->back()->with('success', 'Product added to wishlist!');
        } else {
            // Nếu sản phẩm đã có trong wishlist, thông báo
            return redirect()->route('login.customer')->with('error', 'You need to be logged in to add items to wishlist.');
        }
    } else {
        // Nếu người dùng chưa đăng nhập, yêu cầu đăng nhập
        
        return redirect()->back()->with('info', 'This product is already in your wishlist.');
    }
}


    // Hiển thị danh sách sản phẩm yêu thích
    public function index()
    {
        $userId = Auth::guard('customer')->id();
        $wishlists = Wishlist::where('user_id', $userId)->with('product')->get();

        return view('wishlist.index',['title' => 'Danh sách yêu thích'], compact('wishlists'));
    }
}
