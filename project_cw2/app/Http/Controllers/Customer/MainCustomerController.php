<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainCustomerController extends Controller
{
    //
    public function index()
    {
        return view('customer.home', [
           'title' => 'Trang Customer'
        ]);
    }
}
