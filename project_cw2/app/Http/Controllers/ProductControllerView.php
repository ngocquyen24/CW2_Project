<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\Product\ProductService;

class ProductControllerView extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index($id = '', $slug = '', Request $request)
    {
        $product = $this->productService->show($id);
        $productsMore = $this->productService->more($id);

        return view('products.content', [
            'title' => $product->name,
            'product' => $product,
            'products' => $productsMore
        ]);


    }

    public function searchProduct(Request $request){
        //  // Lấy từ khóa tìm kiếm từ request
        //  $search = $request->input('search-product');

        //  // Nếu có từ khóa tìm kiếm, tìm sản phẩm theo từ khóa đó
        //  if ($search) {
        //  $products = Product::where('name', 'like', '%' . $search . '%')
        //                     ->orWhere('description', 'like', '%' . $search . '%')
        //                     ->paginate(2);
        //  } else {
        //  // Nếu không có từ khóa tìm kiếm, lấy tất cả sản phẩm
        //  $products = Product::paginate(4);
        //  }

        //  return view('products.list', compact('products', 'search'));

        $search = $request->input('search');
        $products = Product::where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->paginate(10);

        return view('products.list', compact('products', 'search'));
    }
}
