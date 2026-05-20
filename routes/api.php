<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Route;

Route::post('/batches', [BatchController::class, 'store']);
Route::get('/batches/profit', [BatchController::class, 'profit']);
Route::post('/batches/{batch}/refunds', [BatchController::class, 'refund']);

Route::get('/products/available', [ProductController::class, 'available']);

Route::post('/orders', [OrderController::class, 'store']);
Route::post('/orders/{order}/refunds', [OrderController::class, 'refund']);

Route::get('/storages/remaining', [StorageController::class, 'remaining']);
