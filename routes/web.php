<?php

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

Route::get('/', [App\Http\Controllers\StoreController::class, 'index'])->name('store');
Route::get('/products', [App\Http\Controllers\StoreController::class, 'index'])->name('products');
Route::get('/products/{id}', [App\Http\Controllers\StoreController::class, 'show'])->name('productsshow');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::post('/cart', [App\Http\Controllers\CartController::class, 'cartAdd'])->name('cartAdd');
Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'cartDel'])->name('cartDel');

Route::get('/checkout1', [App\Http\Controllers\CheckOutController::class, 'index'])->name('checkout1');
Route::post('/checkout2', [App\Http\Controllers\CheckOutController::class, 'store'])->name('checkout2');
Route::get('/checkout3', [App\Http\Controllers\CheckOutController::class, 'invalidCode'])->name('checkout3Empty');
Route::get('/checkout3/{codeunique}', [App\Http\Controllers\CheckOutController::class, 'direction'])->name('checkout3');
Route::post('/checkout4', [App\Http\Controllers\CheckOutController::class, 'storeDirection'])->name('checkout4');
Route::post('/checkout4_5', [App\Http\Controllers\CheckOutController::class, 'selectDirection'])->name('checkout4_5');
Route::get('/checkout5', [App\Http\Controllers\CheckOutController::class, 'invalidCode'])->name('checkout5Empty');
Route::get('/checkout5/{codeunique}', [App\Http\Controllers\CheckOutController::class, 'shipping'])->name('checkout5');
Route::post('/checkout6', [App\Http\Controllers\CheckOutController::class, 'shippingSave'])->name('checkout6');
Route::get('/checkout7', [App\Http\Controllers\CheckOutController::class, 'invalidCode'])->name('checkout7Empty');
Route::get('/checkout7/{codeunique}', [App\Http\Controllers\CheckOutController::class, 'checkoutpay'])->name('checkout7');
Route::get('/checkoutshow', [App\Http\Controllers\CheckOutController::class, 'invalidCode'])->name('checkoutshowEmpty');
Route::get('/checkoutshow/{codeunique}', [App\Http\Controllers\CheckOutController::class, 'show'])->name('checkoutshow');

Route::get('/about', function () {
    return view('about.about');
})->name('about');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/installation_system_full_30062020', [App\Http\Controllers\InstallController::class, 'index'])->name('install');
