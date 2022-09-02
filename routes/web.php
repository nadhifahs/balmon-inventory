<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\RentController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserRegisterController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Admin Authentication
Route::get('/admin', [AdminLoginController::class, 'index'])->name('admin.login.index');
Route::post('/admin', [AdminLoginController::class, 'login'])->name('admin.login.store');

// User Authentication
Route::get('/user/register', [UserRegisterController::class, 'index'])->name('user.register.index');
Route::post('/user/register', [UserRegisterController::class, 'store'])->name('user.register.store');

Route::get('/user', [UserLoginController::class, 'index'])->name('user.login.index');
Route::post('/user', [UserLoginController::class, 'login'])->name('user.login.store');

// Controller User

Route::group(['middleware'=>['auth:web']], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('home.index');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/{id}/document',[CartController::class, 'updateDocument'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/rent', [RentController::class, 'index'])->name('rent.index');
    Route::post('/rent', [RentController::class, 'store'])->name('rent.store');
    Route::get('/logout', [LogoutController::class, 'index'])->name('logout.index');
});

// Controller Admin

Route::group(['middleware' => ['auth:admin'],'prefix'=>'admin','as'=>'admin.'], function(){
    Route::get('/home', [AdminDashboardController::class, 'index'])->name('home.index');
    Route::resource('product/category', ProductCategoryController::class)->parameter('category', 'productCategory');
    Route::resource('product', ProductController::class);
    Route::resource('user', UserController::class);
    Route::resource('admin', AdminController::class);
    Route::get('/logout', [LogoutController::class, 'index'])->name('logout.index');
});
