<?php

use App\Http\Controllers\ShoppingPageController;
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

Route::get('/', [ShoppingPageController::class, 'shopList']);

Route::controller(ShoppingPageController::class)->group(function () {
    Route::get('/shop', 'shopList');

    //  TODO: Show the checkout page
    Route::middleware('auth')->get('/shop/checkout', 'shopCheckout')->name('shopCheckout');

    Route::get('/shop/{id}', 'shopDetail');
});

require __DIR__.'/auth.php';
