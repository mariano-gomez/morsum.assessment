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
    Route::get('/shop/{id}', 'shopDetail');

    //  TODO: Show the checkout page
//    Route::get('/shop/checkout', 'shopCheckout');
});
