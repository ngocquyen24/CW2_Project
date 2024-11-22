<?php

namespace App\Http\Services\CustomerUser;

use App\Models\CustomerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerUserService {

    public function create($request){

        try {

            //kiem tra du lieu  dau vao
         $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customer_users',
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

        CustomerUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'avatar' => $filename ?? NULL,
            // 'avatar' => $avatarName ?? NULL,

        ]);

            Session::flash('success', 'Đăng kí thành công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            Log::info($err->getMessage());
            return  false;
        }

        return  true;
    }
    public function login($request)
    {
        //dd($request->input());



       
    }

}
