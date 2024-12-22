

<?php


// Order Routes

use App\Http\Controllers\CreateOrderController;
use App\Http\Controllers\CreateProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartRedisController;

Route::post('/orders', [CreateOrderController::class, 'create']);
Route::put('/orders/{id}', [CreateOrderController::class, 'update']);
Route::delete('/orders/{id}', [CreateOrderController::class, 'delete']);
Route::get('/orders/{user_id}', [CreateOrderController::class, 'list']);

// Product Routes
Route::post('/products', [CreateProductController::class, 'create']);
Route::put('/products/{id}', [CreateProductController::class, 'update']);
Route::delete('/products/{id}', [CreateProductController::class, 'delete']);
Route::get('/products', [CreateProductController::class, 'list']);


Route::post('/cart/{user_id}', [CartRedisController::class, 'addToCart']);
Route::get('/cart/{user_id}', [CartRedisController::class, 'getCart']);
Route::delete('/cart/{user_id}', [CartRedisController::class, 'removeFromCart']);
Route::post('/cart/{user_id}/update', [CartRedisController::class, 'updateCart']);

