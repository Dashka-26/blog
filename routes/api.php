<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Blog\PostController;
use App\Http\Controllers\Api\Blog\Admin\CategoryController;
use App\Http\Controllers\Api\Blog\Admin\PostController as AdminPostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('blog')->group(function () {
    Route::apiResource('posts', PostController::class)->names('blog.posts');
});

Route::group(['prefix' => 'admin/blog'], function () {
    Route::apiResource('categories', CategoryController::class)
        ->names('blog.admin.categories');

    Route::apiResource('posts', AdminPostController::class)
        ->names('blog.admin.posts');
});
