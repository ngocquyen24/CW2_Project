<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Http\Services\Product\ProductService;

class ProductControllerView extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index($id, $slug)
    {
        try {
            // Giải mã ID
            $decodedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'ID không hợp lệ.');
        }
    
        // Tìm sản phẩm theo ID đã giải mã
        $product = Product::find($decodedId);
    
        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$product) {
            return abort(404);  // Trả về lỗi 404 nếu sản phẩm không tìm thấy
        }
    
        // Lấy thêm sản phẩm liên quan, có thể tùy chỉnh bằng cách khác (không sử dụng category_id nếu không cần)
        $productsMore = Product::limit(5)->get();
    
        // Trả về view với dữ liệu sản phẩm
        return view('products.content', [
            'title' => $product->name,
            'product' => $product,
            'products' => $productsMore
        ]);
    }
    
    public function searchProduct(Request $request)
    {

        $search = $request->input('search');
        $products = Product::where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->paginate(10);

        return view('products.list', compact('products', 'search'));
    }


}
