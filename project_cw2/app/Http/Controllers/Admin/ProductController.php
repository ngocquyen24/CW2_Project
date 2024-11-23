<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Product\ProductAdminService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductAdminService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        // Lấy danh sách sản phẩm từ service
        $products = $this->productService->get();

        // Mã hóa ID của từng sản phẩm
        foreach ($products as $product) {
            $product->encrypted_id = Crypt::encrypt($product->id);
        }

        // Truyền dữ liệu đã mã hóa sang view
        return view('admin.product.list', [
            'title' => 'Danh Sách Sản Phẩm',
            'products' => $products
        ]);
    }

    public function create()
    {
        return view('admin.product.add', [
            'title' => 'Thêm Sản Phẩm Mới',
            'menus' => $this->productService->getMenu()
        ]);
    }


    public function store(ProductRequest $request)
    {
        $this->productService->insert($request);

        return redirect()->back();
    }

    public function show(Product $product)
    {
        return view('admin.product.edit', [
            'title' => 'Chỉnh Sửa Sản Phẩm',
            'product' => $product,
            'menus' => $this->productService->getMenu()
        ]);
    }


    public function update(Request $request, $encrypted_id)
    {
        try {
            // Giải mã ID
            $id = Crypt::decrypt($encrypted_id);
    
            // Tìm sản phẩm theo ID đã giải mã
            $product = Product::find($id);
    
            if (!$product) {
                return redirect()->route('admin.products.list')->with('error', 'Sản phẩm không tồn tại');
            }
    
            // Xử lý cập nhật dữ liệu
            $result = $this->productService->update($request, $product);
    
            if ($result) {
                return redirect()->route('admin.products.list')->with('success', 'Cập nhật sản phẩm thành công!');
            }
    
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại');
        } catch (\Exception $e) {
            // Xử lý lỗi nếu không giải mã được ID
            return redirect()->route('admin.products.list')->with('error', 'ID không hợp lệ hoặc lỗi hệ thống');
        }
    }
    


    public function destroy(Request $request)
    {
        $result = $this->productService->delete($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công sản phẩm'
            ]);
        }

        return response()->json(['error' => true]);
    }
// mã hóa
    public function edit($encrypted_id)
    {
        try {
            $id = Crypt::decrypt($encrypted_id);  // Giải mã ID
            $product = Product::findOrFail($id);  // Nếu không tìm thấy sản phẩm sẽ ném lỗi 404
            $menus = Menu::all();  // Giả sử bạn có bảng Menu
            return view('admin.product.edit', [
                'product' => $product,
                'menus' => $menus,
                'title' => 'Chỉnh Sửa Sản Phẩm',
                'encrypted_id' => $encrypted_id,  // Truyền encrypted_id vào view
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.products.list')->with('error', 'Sản phẩm không tồn tại hoặc ID không hợp lệ');
        }
    }
}
