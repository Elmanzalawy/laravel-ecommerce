<?php

use App\Http\Controllers\Api\V1\ProductCategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function () {
    Route::apiResource('products', ProductController::class)->only(['index', 'show']);
    Route::apiResource('product-categories', ProductCategoryController::class)->only(['index', 'show']);
});
