<?php

<<<<<<<< HEAD:project_cw2/app/Http/Controllers/Customer/LoginCustomerController.php
namespace App\Http\Controllers\Customer;
use App\Models\CustomerUser;
========
namespace App\Http\Controllers\Admin\Users;

use view;
use App\Models\User;
use Illuminate\Support\Str;
>>>>>>>> customer_history_cart:project_cw2/app/Http/Controllers/Admin/Users/LoginController.php
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
<<<<<<<< HEAD:project_cw2/app/Http/Controllers/Customer/LoginCustomerController.php
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
========
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
>>>>>>>> customer_history_cart:project_cw2/app/Http/Controllers/Admin/Users/LoginController.php

class LoginCustomerController extends Controller
{
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
         //kiem tra du lieu  dau vao
         $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|same:password1',
            'phone' => 'required|min:10',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);
         //Kiem tra tep tin co truong du lieu avatar hay kh
         if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();//Lay ten mo rong .jpg, .png...
            $filename = time().'.'.$extension;//
            $file->move('avatar/',$filename) ;  //upload len thu muc avatar trong public
        }

        //Lay tat ca co so du lieu gan vao mang data
        $data = $request->all();

        $check = CustomerUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'avatar' => $filename ?? NULL,
            // 'avatar' => $avatarName ?? NULL,

        ]);

        return redirect("/login");
    }

    public function store(Request $request ) {
        //dd($request->input());

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
