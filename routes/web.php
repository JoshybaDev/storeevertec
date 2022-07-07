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

Route::controller(App\Http\Controllers\CheckOutController::class)->group(function () {
    Route::get('/checkout1', 'index')->name('checkout1');
    Route::post('/checkout2', 'store')->name('checkout2');
    Route::get('/checkout3', 'invalidCode')->name('checkout3Empty');
    Route::get('/checkout3/{codeunique}', 'direction')->name('checkout3');
    Route::post('/checkout4', 'storeDirection')->name('checkout4');
    Route::post('/checkout4_5', 'selectDirection')->name('checkout4_5');
    Route::get('/checkout5', 'invalidCode')->name('checkout5Empty');
    Route::get('/checkout5/{codeunique}', 'shipping')->name('checkout5');
    Route::post('/checkout6', 'shippingSave')->name('checkout6');
    Route::get('/checkout7', 'invalidCode')->name('checkout7Empty');
    Route::get('/checkout7/{codeunique}', 'checkoutpay')->name('checkout7');
    Route::get('/checkoutshow', 'invalidCode')->name('checkoutshowEmpty');
    Route::get('/checkoutshow/{codeunique}',  'show')->name('checkoutshow');
    Route::post('/startProcessPay', 'startProcessPay')->name('startProcessPay');
    Route::get('/responseProcessPay', 'responseProcessPay')->name('responseProcessPay');
});

Route::get('/about', function () {
    return view('about.about');
})->name('about');
Auth::routes();
Route::controller(App\Http\Controllers\OrderController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
    Route::get('/orders', 'index')->name('orders');
    Route::get('/orders/{id}', 'show')->name('orders.show');
    Route::get('/showUrlPay/{id}', 'showUrlPay')->name('order.showUrlPay');
    Route::post('/ordersended', 'ordersended')->name('order.sended');
});

Route::controller(App\Http\Controllers\InstallController::class)->group(function () {
    Route::get('/installation_system_full_30062020', 'index')->name('install');
    Route::get('/emailshowtest/{codeunique}', 'emailshowtest')->name('emailshowtest');
    Route::get('/emailsendtest/{codeunique}', 'sendEmailCheckOut')->name('emailsendtest');
});
