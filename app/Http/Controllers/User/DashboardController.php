<?php

namespace App\Http\Controllers\User;

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
        $availableProduct = Product::where('quantity', 1)->count();
        $rentProduct = Product::whereHas('cart_detail', function($query){
            $query->where('status', 'RENT');
        })->count();
        $goodProduct = Product::whereCondition('BAIK')->count();
        $badProduct = Product::whereCondition('RUSAK')->count();
        $maintenanceProduct = Product::whereCondition('MAINTENANCE')->count();

        return view('user.home.index', compact(
            'mainPageTitle',
            'subPageTitle',
            'pageTitle',
            'totalProduct',
            'rentProduct',
            'goodProduct',
            'badProduct',
            'availableProduct',
            'maintenanceProduct'
        ));
    }
}
