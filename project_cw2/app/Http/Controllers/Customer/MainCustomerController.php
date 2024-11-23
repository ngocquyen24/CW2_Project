<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Services\CartService;
use App\Http\Controllers\Controller;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Slider\SliderService;
use App\Http\Services\Product\ProductService;

class MainCustomerController extends Controller
{
    protected $slider;
    protected $menu;
    protected $product;
    protected $cart;




    public function __construct(SliderService $slider, MenuService $menu,CartService $cart,
        ProductService $product)
    {
        $this->slider = $slider;
        $this->menu = $menu;
        $this->product = $product;
        $this->cart = $cart;
    }

    public function index()
    {
        return view('home', [
            'title' => 'Happy Chicken',
            'sliders' => $this->slider->show(),
            'menus' => $this->menu->show(),
            'products' => $this->product->get()
        ]);
    }

    public function profile()
    {
        return view('customer.history.profile', [
            'title' => 'Danh Sách Đơn Đặt Hàng',
            'customers' => $this->cart->getCustomerUser()
        ]);
    }
}
