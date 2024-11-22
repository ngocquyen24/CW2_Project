<?php

namespace App\Http\Controllers\Customer;
use App\Models\CustomerUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\CustomerUser\CustomerUserService;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
    use Illuminate\Validation\ValidationException;

class LoginCustomerController extends Controller
{
    protected $customerUserService;
    public function __construct(CustomerUserService $customerUserService)
    {
        $this->customerUserService = $customerUserService;
    }
    public function index(){
        return view('customer.login',[
            'title' => 'Customer'
        ]);
    }
    public function indexRegister(){

        return view('customer.register',[
            'title' => 'Register Customer'
        ]);
    }
    public function register(Request $request)
    {
        $this->customerUserService->create($request);

        return redirect("customer/login");
    }

    public function store(Request $request ) {
        $this->validate($request, [
            'email' => 'required|email:filter',
            'password' => 'required',

       ]);

       if(Auth::guard('customer')->attempt(['email' => $request->input('email'),
            'password' => $request->input('password'),

            ], $request->input('remember') )) {
            return redirect()->route('customer');
       }
       Session::flash('error','Email hoac Password khong dung');

        $this->customerUserService->login($request);
       return redirect()->back();
    }

    /**
     * Sign out
     */
    public function signOut() {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }

}
