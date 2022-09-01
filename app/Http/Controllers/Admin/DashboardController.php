<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $mainPageTitle = 'Dashboard';
        $subPageTitle = 'Main';
        $pageTitle = 'Dashboard Admin';

        $totalProduct = Product::count();
        $totalUser = User::count();
        $totalAdmin = User::count();
        // $rentProduct = Product::with('cart_detail')->get();
        // dd($rentProduct);

        return view('admin.home.index', compact(
            'mainPageTitle',
            'subPageTitle',
            'pageTitle',
            'totalProduct',
            'totalUser',
            'totalAdmin',
            // 'rentProduct',
            // 'availableProduct'
        ));
    }
}
