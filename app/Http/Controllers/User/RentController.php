<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RentController extends Controller
{
    public function index(Request $request)
    {
        $mainPageTitle = 'Peminjaman';
        $subPageTitle = 'Main';
        $pageTitle = 'Peminjaman';

        if($request->ajax()){
            $products = Product::with('product_category')->whereDoesntHave('cart_detail', function($query)
            {
                $query->whereNull('status');
            })->select();
            return datatables()->of($products)
            ->addIndexColumn()
            ->addColumn('action', function($query){
                return $this->getActionColumn($query);
            })
            ->addColumn('product_category.name', function($query){
                return isset($query->product_category->name) ? $query->product_category->name : 'Belum Set Category';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('user.rent.index', compact('mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        $cartStatus = Auth::user()->cart()->whereIn('status', ['RENT', 'READY TO PICKUP'])->first();
        if($cartStatus == null)
        {
            $productStock = Product::whereId($request->product_id)->first();
            if($productStock->quantity <= 0){
                return redirect()->route('rent.index')->with('error', 'Quantity tidak tersedia untuk product ini');
            }
            $productStock->decrement('quantity', 1);

            $cart = Auth::user()->cart()->updateOrCreate([
                'status' => 'WAITING'
            ]);

            $cart->cart_detail()->updateOrCreate([
                'product_id' => $request->product_id],[
                'quantity' => 1
            ]);

            return redirect()->route('rent.index')->with('status', 'Berhasil menambahkan ke cart');
        }else{
            return redirect()->route('rent.index')->with('error', 'Silahkan selesaikan peminjaman terlebih dahulu');
        }
    }

    public function pickup(Request $request)
    {
        $mainPageTitle = 'Peminjaman';
        $subPageTitle = 'Main';
        $pageTitle = 'Pickup';
        $cart = Auth::user()->cart()->with('cart_detail','cart_detail.product', 'admin')->where('status', 'READY TO PICKUP')->first();
        return view('user.rent.pickup', compact('cart','mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    public function getActionColumn($query)
    {
        $addToCartBtn = route('rent.store');
        $ident = Str::random(10);
        return '<input form="form'.$ident .'" type="submit" value="Add to Cart" class="mx-1 my-1 btn btn-sm btn-success">
        <form id="form'.$ident .'" action="'.$addToCartBtn.'" method="post">
        <input type="hidden" name="_token" value="'.csrf_token().'" />
        <input type="hidden" name="product_id" value="'.$query->id.'">
        </form>';
    }
}
