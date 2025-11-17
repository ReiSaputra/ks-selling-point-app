<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    return view('welcome');
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
    Route::get("/dashboard", function () {
        return view("dashboard");
    }); 
});