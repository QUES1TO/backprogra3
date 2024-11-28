<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

Route::post('/user/login', [UserController::class, 'login']);
Route::post('/user/signUp', [UserController::class, 'signUp']);
Route::resource('producto', ProductController::class);
Route::resource('categoria', CategoriaController::class);
Route::middleware('jwt')->group(function () {
    Route::get('/user/lista', [UserController::class, 'index']);
   
    Route::group(['middleware' => ['role:Admin|Seller']], function () {      
        
    });
    Route::group(['middleware' => ['role:Admin']], function () {      
        Route::resource('product', ProductController::class); 

        Route::post('/user/signUpSeller', [UserController::class, 'signUpSeller']); 
    });
});
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
