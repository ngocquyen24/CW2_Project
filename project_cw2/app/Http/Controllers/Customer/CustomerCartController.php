<?php

namespace App\Http\Controllers\Customer;


use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Services\CartService;
use App\Http\Controllers\Controller;

class CustomerCartController extends Controller
{
    protected $cart;
    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }



    public function show(Customer $customer)
    {
        $carts = $this->cart->getProductForCart($customer);

        return view('customer.history.detail', [
            'title' => 'Chi Tiết Đơn Hàng: ' . $customer->name,
            'customer' => $customer,
            'carts' => $carts
        ]);
    }

    // public function destroyCartAdmin($customerId)
    // {
    //     Cart::where('customer_id', $customerId)->delete();
    // }


}
