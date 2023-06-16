<?php

use App\Http\Controllers\Admin\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StoreConfigurationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\UserOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('register/store', [LoginController::class, 'registerStore'])->name('register.store');
Route::get('register', [LoginController::class, 'register'])->name('register');
Route::post('login/store', [LoginController::class, 'loginStore'])->name('login.store');
Route::get('login', [LoginController::class, 'index'])->name('login');

Route::post('cart/destroy', [HomeController::class, 'cartDestroy'])->name('cart.destroy');
Route::post('cart/store', [HomeController::class, 'cartStore'])->name('cart.store');
Route::post('cart/check-stock', [HomeController::class, 'cartCheckStock'])->name('cart.check-stock');
Route::get('cart', [HomeController::class, 'cart'])->name('cart');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('dashboard')->group(function () {
    Route::post('user/order/confirm/{id}', [UserOrderController::class, 'confirm'])->name('user-customer.order.confirm');
    Route::resource('user/order', UserOrderController::class, ['as' => 'user-customer']);
    Route::resource('checkout', CheckoutController::class, ['as' => 'customer']);
})->middleware(['auth']);

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'role.admin']], function () {
    Route::get('/', DashboardController::class)->name('admin.dashboard');

    // Order
    Route::post('order/change-status', [OrderController::class, 'changeStatus'])->name('admin.order.change-status');
    Route::resource('order', OrderController::class, ['as' => 'admin']);

    // Setting
    Route::post('setting/user/list', [SettingController::class, 'store'])->name('admin.setting.user.list');

    // Setting
    Route::resource('setting', SettingController::class, ['as' => 'admin']);

    // Product
    Route::resource('product', ProductController::class, ['as' => 'admin']);

    //User
    Route::resource('user', UserController::class, ['as' => 'admin']);

    // Configuration Store
    Route::resource('store-configuration', StoreConfigurationController::class, ['as' => 'admin']);
});
