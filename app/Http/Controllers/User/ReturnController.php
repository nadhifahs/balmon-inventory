<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index()
    {
        $mainPageTitle = 'Peminjaman';
        $subPageTitle = 'Main';
        $pageTitle = 'Pickup';
        $cart = Auth::user()->cart()->with('cart_detail','cart_detail.product', 'admin')->where('status', 'RENT')->first();
        return view('user.rent.pickup', compact('cart','mainPageTitle', 'subPageTitle', 'pageTitle'));
    }
}
