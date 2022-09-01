<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentController extends Controller
{
    public function index(Request $request)
    {
        $mainPageTitle = 'Peminjaman';
        $subPageTitle = 'Main';
        $pageTitle = 'Peminjaman';

        if($request->ajax()){
            $products = Product::with('product_category')->select();
            return datatables()->of($products)
            ->addIndexColumn()
            ->addColumn('action', function($query){

            })
            ->addRawColumns(['action'])
            ->make(true);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
        ]);

        $cartStatus = Auth::user()->cart->latest->status;

        if( $cartStatus == 'WAITING' || $cartStatus == null){

            $cart = Auth::user()->cart->updateOrCreate([
                'status' => 'WAITING'
            ]);

            $cart->cart_detail->updateOrCreate([
                'product_id' => $request->product_id,
                'quantity' => 1
            ]);

            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 400);
        }
    }

    public function getActionColumn($query)
    {
        return '<button class="btn btn-primary btn-pill">Add To Cart</button>';
    }
}
