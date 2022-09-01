<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
			Auth::guard('admin')->logout();
			session()->flush();
            return redirect(route('admin.login.index'));
		}else{
            Auth::guard('web')->logout();
            session()->flush();
            return Redirect(route('user.login.index'));
        }
    }
}
