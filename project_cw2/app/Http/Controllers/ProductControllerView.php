<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function searchProduct(Request $request)
    {
        $searchTerm = $request->input('search');

        if ($searchTerm) {
            // Thực hiện tìm kiếm fulltext với MySQL
            $products = DB::table('products')
                ->whereRaw("MATCH(name, description) AGAINST (? IN NATURAL LANGUAGE MODE)", [$searchTerm])
                ->get();
        } else {
            $products = Product::all();
        }

        return view('products.result_search',['title' => 'search','product' => 'product',], compact('products'));
    }
}
