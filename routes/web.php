<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use GuzzleHttp\Middleware;
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

Route::redirect('/', "/home");

Route::get('/home', [ProductController::class, 'index'])->name("home");

Route::middleware("guest")->group(
    function () {
        Route::get("/login", [LoginController::class, 'create'])->name("login");
        Route::post('/login', [LoginController::class, 'store']);

        Route::get("/register", [RegisterController::class, 'create']);
        Route::post('/register', [RegisterController::class, 'store']);
    }
);

Route::middleware("auth")->group(
    function () {
        Route::get('/new-product',[ProductController::class,'create']);
        Route::post('/new-product',[ProductController::class,'store']);

        Route::get('/edit-product/{id}',[ProductController::class,'edit']);
        Route::post('/edit-product/{id}',[ProductController::class,'update']);

        Route::post('/delete-product/{id}',[ProductController::class,'destroy']);



        Route::post('/logout', [LoginController::class, 'destroy']);
    }
);
