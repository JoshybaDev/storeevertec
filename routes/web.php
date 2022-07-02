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



Route::get('/about', function () {
    return view('about.about');
})->name('about');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
