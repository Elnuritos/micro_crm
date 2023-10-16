<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\WarehouseController;
use App\Http\Controllers\API\ProductMovementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('warehouses')->group(function () {
    Route::get('/', [WarehouseController::class, 'index']);
    Route::get('{id}', [WarehouseController::class, 'show']);
});


Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('{id}', [ProductController::class, 'show']);
});

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('{id}', [OrderController::class, 'show']);
    Route::post('/', [OrderController::class, 'store']);
    Route::put('{id}', [OrderController::class, 'update']);
    Route::patch('{id}/complete', [OrderController::class, 'complete']);
    Route::patch('{id}/cancel', [OrderController::class, 'cancel']);
    Route::patch('{id}/resume', [OrderController::class, 'resume']);
});

Route::prefix('movements')->group(function () {
    Route::post('/', [ProductMovementController::class, 'index']);
});
