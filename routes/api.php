<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PiecesController; 
use App\Http\Controllers\AdminController; 
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




Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('register', [AuthController::class, 'register']);


Route::middleware(['auth:api', 'role:admin'])->get('/admin', function (Request $request) {
    return response()->json(['message' => 'Welcome Admin']);
});


Route::group(['middleware' => ['role:admin']], function () {
    Route::get('brand', [BrandController::class, 'index']);
    Route::post('insert-brand', [BrandController::class, 'insert']);
    Route::post('update-brand/{id}', [BrandController::class, 'update']);
    Route::get('delete-brand/{id}', [BrandController::class, 'delete']);
    Route::get('detail-brand/{id}', [BrandController::class, 'detail']);
    
    Route::get('category', [CategoryController::class, 'index']);
    Route::post('insert-category', [CategoryController::class, 'insert']);
    Route::post('update-category/{id}', [CategoryController::class, 'update']);
    Route::get('delete-category/{id}', [CategoryController::class, 'delete']);
    Route::get('detail-category/{id}', [CategoryController::class, 'detail']);

    Route::get('pieces', [PiecesController::class, 'index']);
    Route::post('insert-pieces', [PiecesController::class, 'insert']);
    Route::post('update-pieces/{id}', [PiecesController::class, 'update']);
    Route::get('delete-pieces/{id}', [PiecesController::class, 'delete']);
    Route::get('detail-pieces/{id}', [PiecesController::class, 'detail']);

    Route::get('admin', [AdminController::class, 'index']);
    Route::post('insert-admin', [AdminController::class, 'insert']);
    Route::post('update-admin/{id}', [AdminController::class, 'update']);
    Route::get('delete-admin/{id}', [AdminController::class, 'delete']);
    Route::get('detail-admin/{id}', [AdminController::class, 'detail']);
    
});

Route::middleware(['auth:api', 'role:pelanggan'])->get('/pelanggan', function (Request $request) {
    return response()->json(['message' => 'Welcome Pelanggan']);
});