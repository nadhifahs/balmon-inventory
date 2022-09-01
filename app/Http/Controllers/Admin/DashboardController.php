<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $mainPageTitle = 'Dashboard';
        $subPageTitle = 'Main';
        $pageTitle = 'Dashboard';

        $totalProduct = Product::count();
        $rentProduct = Product::withCount('cart_detail')->get();
        // dd($rentProduct);
        // $availableProduct = $totalProduct - $rentProduct;

        return view('admin.home.index', compact(
            'mainPageTitle',
            'subPageTitle',
            'pageTitle',
            'totalProduct',
            'rentProduct',
            // 'availableProduct'
        ));
    }
}
