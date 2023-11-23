<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\ProductController;

Route::group(['middleware' => 'api'], function () {
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'getProducts']);
        Route::post('/', [ProductController::class, 'createProduct']);
        Route::get('/{id}', [ProductController::class, 'detailProduct']);
        Route::put('/{id}', [ProductController::class, 'updateProduct']);
        Route::delete('/{id}', [ProductController::class, 'destroyProduct']);
    });
});
