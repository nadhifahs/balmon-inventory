<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function index()
    {
        if(Auth::guard('admin')->check()){
            return redirect(route('home.index'));
        }
        return view('auth.admin.signin');
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
				->intended(route('home.index'))
				->with('status','Sukses Login Sebagai Admin!');
        }else{
            return back()->withErrors('username / password anda salah!');
        }
    }

    public function logout()
    {
        if (Auth::guard('admin')->check()) {
			Auth::guard('admin')->logout();
			session()->flush();
		}else{
            Auth::guard('web')->logout();
            session()->flush();
        }
        return Redirect(route('login.index'));
    }
}
