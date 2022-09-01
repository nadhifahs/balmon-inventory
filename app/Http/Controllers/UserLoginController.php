<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    public function index()
    {
        if(Auth::guard('web')->check()){
            return redirect(route('user.profile.edit'));
        }
        return view('auth.user.login');
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
            $auth = Auth::guard('web')->attempt(['email' => $username, 'password' => $password], $request->filled('remember'));
        }else{
            $auth = Auth::guard('web')->attempt(['username' => $username, 'password' => $password], $request->filled('remember'));
        }

        if($auth){
            return redirect()
				->intended(route('home.index'))
				->with('status','Sukses Login Sebagai User!');
        }else{
            return back()->withErrors('username / password anda salah!');
        }
    }

    public function logout()
    {
        if (Auth::guard('web')->check()) {
			Auth::guard('web')->logout();
			session()->flush();
			return redirect(route('user.login.index'));
		}
    }
}
