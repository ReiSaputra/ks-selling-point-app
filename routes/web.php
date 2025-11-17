<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    return redirect()->route("order-list");
});

/**
 * Authentication route
 */
Route::prefix("auth")->group(function () {
    Route::get("/login", "AuthController@showLogin")->name("login");
    Route::post("/login", "AuthController@login")->name("login.perform");

    Route::get("/register", "AuthController@showRegister")->name("register");
    Route::post("/register", "AuthController@register")->name("register.perform");
});

/**
 * Admin route (protected by auth middleware)
 */
Route::middleware(["auth"])->group(function () {
    Route::get("/order-list", "OrderListController@show")->name("order-list");
    Route::post("/order-list", "OrderListController@preview")->name("order-list.preview");
    Route::post("/order-list/perform", "OrderListController@perform")->name("order-list.perform");
});