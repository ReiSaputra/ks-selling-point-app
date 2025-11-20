<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderListController;
use App\Http\Controllers\UploadCSVController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route("order-list");
});

/**
 * Authentication route
 */
Route::prefix("auth")->group(function () {

    Route::get("/login", [AuthController::class, 'showLogin'])->name("login");
    Route::post("/login", [AuthController::class, 'login'])->name("login.perform");

    Route::get("/register", [AuthController::class, 'showRegister'])->name("register");
    Route::post("/register", [AuthController::class, 'register'])->name("register.perform");

});

/**
 * Admin route (protected by auth middleware)
 */
Route::middleware(["auth"])->group(function () {

    Route::get("/order-list", [OrderListController::class, 'show'])->name("order-list");

    Route::get("/upload-csv", [UploadCSVController::class, 'show'])->name("upload-csv");
    Route::post("/upload-csv", [UploadCSVController::class, 'preview'])->name("upload-csv.preview");
    Route::post("/upload-csv/perform", [UploadCSVController::class, 'perform'])->name("upload-csv.perform");

    Route::get("/report", [ReportController::class, 'show'])->name("report");

});
