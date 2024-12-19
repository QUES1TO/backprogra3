<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ComentarioController;

 
Route::post('/user/login', [UserController::class, 'login']);
Route::post('/user/signUp', [UserController::class, 'signUp']);
Route::get('/user/data', [UserController::class, 'index']);
Route::resource('producto', ProductoController::class);

Route::resource('user', UserController::class);
Route::resource('comentario', ComentarioController::class)->parameters(['comentario' => 'comentario']);

Route::resource('categoria', CategoriaController::class)->parameters(['categoria' => 'categoria']);
Route::get('product', [ProductoController::class, 'index']);
//Route::put('/product/{id}', [ProductoController::class, 'update']);
Route::get('product2', [ProductoController::class, 'index2']);


//Route::post('/categoria_repuestos', [Categoria_RepuestosController::class, 'store']);
//Route::post('producto', [ProductoController::class, 'store']);


Route::middleware('client')->group(function () {
    Route::get('/user/lista', [UserController::class, 'index']);        
//Route::resource('adorno', AdornoController::class);
    Route::group(['middleware' => ['role:Admin']], function () {
        //route::post('categoria', [CategoriaController::class, 'store']);
        //Route::resource('producto', ProductoController::class);
        //Route::resource('categoria_repuestos', Categoria_RepuestosController::class);
        //Route::resource('producto', ProductoController::class);
       // Route::resource('repuestos', RepuestosController::class);
      // Route::resource('carito', CaritoController::class);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
