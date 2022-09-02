<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfirmController extends Controller
{
    public function index()
    {
        $mainPageTitle = 'Confirm Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Home Confirm';

        return view('admin.confirm.scan', compact('mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    public function edit($id)
    {
        $mainPageTitle = 'Confirm Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Update Confirm';

        $cart = Cart::with('cart_detail', 'cart_detail.product', 'admin')->where('rent_code', $id)->first();

        return view('admin.confirm.edit', compact('cart', 'mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    public function store(Request $request)
    {
        $cartData = $cart = Cart::where('rent_code', $request->rent_code)->first();
        $msg = $cartData->status == 'READY TO PICKUP' ? 'Success Meminjamkan Barang' : 'Success Menerima Barang';
        $cart = Cart::where('rent_code', $request->rent_code)->update([
            'status' => $cartData->status == 'READY TO PICKUP' ? 'RENT' : 'RETURN',
            'admin_id' => Auth::guard('admin')->user()->id,
        ]);

        return redirect()->route('admin.home.index')->with('status', $msg);
    }
}
