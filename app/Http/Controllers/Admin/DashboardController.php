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

        $availableProduct = Product::where('quantity', 1)->count();
        $rentProduct = Product::whereHas('cart_detail', function($query){
            $query->where('status', 'RENT');
        })->count();
        $goodProduct = Product::whereCondition('BAIK')->count();
        $badProduct = Product::whereCondition('RUSAK')->count();
        $maintenanceProduct = Product::whereCondition('MAINTENANCE')->count();

        return view('admin.home.index', compact(
            'mainPageTitle',
            'subPageTitle',
            'pageTitle',
            'totalProduct',
            'totalUser',
            'totalAdmin',
            'rentProduct',
            'goodProduct',
            'badProduct',
            'availableProduct',
            'maintenanceProduct'
            // 'rentProduct',
            // 'availableProduct'
        ));
    }
}
