<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    public function index()
    {
        $mainPageTitle = 'Peminjaman';
        $subPageTitle = 'Main';
        $pageTitle = 'Kembalikan';
        $cart = Auth::user()->cart()->with('cart_detail','cart_detail.product', 'admin')->whereNotNull('admin_id')->where('status', 'RENT')->first();
        if($cart == null){
            return redirect()->route('rent.index')->with('error', 'Tidak ada barang dipinjam');
        }
        return view('user.rent.pickup', compact('cart','mainPageTitle', 'subPageTitle', 'pageTitle'));
    }
}
