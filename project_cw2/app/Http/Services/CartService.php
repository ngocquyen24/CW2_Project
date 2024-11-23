<?php


namespace App\Http\Services;


use App\Models\Cart;
use App\Jobs\SendMail;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function create($request)
    {
        $qty = (int)$request->input('num_product');
        $product_id = (int)$request->input('product_id');

        if ($qty <= 0 || $product_id <= 0) {
            Session::flash('error', 'Số lượng hoặc Sản phẩm không chính xác');
            return false;
        }

        $carts = Session::get('carts');
        if (is_null($carts)) {
            Session::put('carts', [
                $product_id => $qty
            ]);
            return true;
        }

        $exists = Arr::exists($carts, $product_id);
        if ($exists) {
            $carts[$product_id] = $carts[$product_id] + $qty;
            Session::put('carts', $carts);
            return true;
        }

        $carts[$product_id] = $qty;
        Session::put('carts', $carts);

        return true;
    }

    public function getProduct()
    {
        $carts = Session::get('carts');
        if (is_null($carts)) return [];

        $productId = array_keys($carts);
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();
    }

    public function update($request)
    {
        Session::put('carts', $request->input('num_product'));

        return true;
    }

    public function remove($id)
    {
        $carts = Session::get('carts');
        unset($carts[$id]);

        Session::put('carts', $carts);
        return true;
    }

    public function addCart($request)
    {
        try {
            // Kiểm tra người dùng đã đăng nhập với guard 'customer'
            if (!Auth::guard('customer')->check()) {
                Session::flash('error', 'Bạn cần đăng nhập để đặt hàng.');
                return redirect()->route('login.customer'); // Chuyển hướng về trang đăng nhập
            }

            // Lấy email của người dùng hiện đang đăng nhập với guard 'customer'
            $email = Auth::guard('customer')->user()->email;

            DB::beginTransaction();

            $carts = Session::get('carts');

            if (is_null($carts)) {
                Session::flash('error', 'Giỏ hàng rỗng.');
                return false;
            }

            // Tạo thông tin khách hàng
            $customer = Customer::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $email, // Sử dụng email của người dùng đã đăng nhập
                'content' => $request->input('content')
            ]);

            $this->infoProductCart($carts, $customer->id);

            DB::commit();
            Session::flash('success', 'Đặt hàng thành công');

            // Gửi email xác nhận đơn hàng
            SendMail::dispatch($email)->delay(now()->addSeconds(2));

            // Xóa giỏ hàng khỏi Session
            Session::forget('carts');
        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', 'Đặt hàng lỗi, vui lòng thử lại sau.');
            return false;
        }

        return true;
    }

    protected function infoProductCart($carts, $customer_id)
    {
        $productId = array_keys($carts);
        $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();

        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'customer_id' => $customer_id,
                'product_id' => $product->id,
                'pty'   => $carts[$product->id],
                'price' => $product->price_sale != 0 ? $product->price_sale : $product->price
            ];
        }

        return Cart::insert($data);
    }

    public function getCustomer()
    {
        return Customer::orderByDesc('id')->paginate(3);
    }

    public function getCustomerUser()
    {
        // Lấy email của người dùng đang đăng nhập
        $email = Auth::guard('customer')->user()->email;

    // Lấy danh sách theo email từ cơ sở dữ liệu
    $records = DB::table('customers') // Thay 'your_table_name' bằng tên bảng của bạn
                 ->where('email', $email)
                 ->paginate(2); // Hiển thị 2 bản ghi mỗi trang

    // Trả về danh sách
    return $records;

    }

    public function getProductForCart($customer)
    {
        return $customer->carts()->with(['product' => function ($query) {
            $query->select('id', 'name', 'thumb');
        }])->get();
    }
}
