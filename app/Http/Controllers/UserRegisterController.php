<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserRegisterController extends Controller
{
    public function index()
    {

        return view('auth.user.register');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'name' => 'required|min:5',
        ]);

        $user = User::create(array_merge($request->only('username', 'email', 'name'),[
            'password' => bcrypt($request->password),
            'avatar' => 'storage/placeholder/avatar/default-profile.png'
        ]));

        return redirect()->route('user.login.index')->with('status', 'Berhasil registrasi, silahkan login terlebih dahulu');

    }

}
