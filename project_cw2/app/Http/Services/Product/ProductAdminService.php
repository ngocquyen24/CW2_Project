<?php


namespace App\Http\Services\Product;


use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProductAdminService
{
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }

    protected function isValidPrice($request)
    {
        if ($request->input('price') != 0 && $request->input('price_sale') != 0
            && $request->input('price_sale') >= $request->input('price')
        ) {
            Session::flash('error', 'Giá giảm phải nhỏ hơn giá gốc');
            return false;
        }

        if ($request->input('price_sale') != 0 && (int)$request->input('price') == 0) {
            Session::flash('error', 'Vui lòng nhập giá gốc');
            return false;
        }

        return  true;
    }

    public function insert($request)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false) return false;

        try {
            $product = new Product();
            $product->name = (string)$request->input('name');
            $product->description = (string)$request->input('description');
            $product->content = (string)$request->input('content');
            $product->menu_id = (int)$request->input('menu_id');

            $product->price = (int)$request->input('price');
            $product->price_sale = (int)$request->input('price_sale');
            $product->active = (string)$request->input('active');

            if ($request->hasFile('thumb')) {
                $file = $request->file('thumb');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move('thumb', $filename);
                $product->thumb = $filename;
            }

            $product->save();

            // Mã hóa ID sau khi lưu và trả về mã hóa
            $encryptedId = Crypt::encrypt($product->id);

            Session::flash('success', 'Thêm sản phẩm thành công');
            return ['status' => true, 'encrypted_id' => $encryptedId];
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            Log::info($err->getMessage());
            return false;
        }
    }

    public function get()
    {  // Lấy danh sách sản phẩm
        $products = Product::with('menu')
            ->orderBy('id')
            ->paginate(3);

        // Mã hóa ID cho từng sản phẩm
        foreach ($products as $product) {
            $product->encrypted_id = Crypt::encrypt($product->id);
        }

        return $products;
    }

    public function update($request, $product)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false) return false;

        try {
            // Lấy ID của sản phẩm
            $productId = $product->id;

            // Mã hóa ID
            $encryptedId = Crypt::encrypt($productId);
            Log::info('ID sản phẩm sau khi mã hóa: ' . $encryptedId);

            // Cập nhật thông tin sản phẩm
            $product->name = (string)$request->input('name');
            $product->description = (string)$request->input('description');
            $product->content = (string)$request->input('content');
            $product->menu_id = (int)$request->input('menu_id');
            $product->price = (int)$request->input('price');
            $product->price_sale = (int)$request->input('price_sale');
            $product->active = (string)$request->input('active');

            // Cập nhật ảnh thumb nếu có
            if ($request->hasFile('thumb')) {
                $file = $request->file('thumb');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move('thumb', $filename);
                $product->thumb = $filename;
            }

            $product->save();

            Session::flash('success', 'Cập nhật thành công');

            // Trả về ID đã mã hóa (nếu cần)
            return $encryptedId;
        } catch (\Exception $err) {
            Session::flash('error', 'Có lỗi vui lòng thử lại');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function delete($request)
    {
        try {
            // Giải mã ID trước khi xóa
            $decryptedId = Crypt::decrypt($request->input('id'));
            $product = Product::where('id', $decryptedId)->first();

            if ($product) {
                $product->delete();
                return true;
            }

            return false;
        } catch (\Exception $err) {
            Session::flash('error', 'ID không hợp lệ');
            Log::info($err->getMessage());
            return false;
        }
    }
}
