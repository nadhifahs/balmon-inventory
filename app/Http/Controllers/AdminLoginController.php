<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function index()
    {
        if(Auth::guard('admin')->check()){
            return redirect(route('admin.home.index'));
        }
        return view('auth.admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->username;
        $password = $request->password;

        if(filter_var($username, FILTER_VALIDATE_EMAIL)){
            $auth = Auth::guard('admin')->attempt([
                'email' => $username,
                'password' => $password
            ]);
        }else{
            $auth = Auth::guard('admin')->attempt([
                'username' => $username,
                'password' => $password
            ]);
        }

        if($auth){
            return redirect()
				->intended(route('admin.home.index'))
				->with('status','Sukses Login Sebagai Admin!');
        }else{
            return back()->withErrors('username / password anda salah!');
        }
    }

}
