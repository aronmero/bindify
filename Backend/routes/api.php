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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::middleware('auth:sanctum')->apiResource('commerce', CommercesController::class)->except(['index', 'destroy']);
Route::middleware('auth:sanctum')->apiResource('customer', CustomersController::class)->except(['index', 'destroy']);
Route::middleware('auth:sanctum')->apiResource('post', PostsController::class)->except(['index']);
Route::middleware('auth:sanctum')->apiResource('comment', CommentsController::class)->except(['index']);
Route::middleware('auth:sanctum')->apiResource('review', ReviewsController::class)->except(['index']);
Route::middleware('auth:sanctum')->apiResource('hashtag', HashtagsController::class)->except(['show', 'update', 'destroy']);
Route::middleware('auth:sanctum')->apiResource('municipality', MunicipalitiesController::class)->except(['show', 'update', 'destroy', 'store']);
Route::middleware('auth:sanctum')->apiResource('category', CategoriesController::class)->except(['show', 'update', 'destroy', 'store']);
Route::middleware('auth:sanctum')->apiResource('post_type', Post_typesController::class)->except(['show', 'update', 'destroy', 'store']);
Route::middleware('auth:sanctum')->apiResource('notification', NotificationsController::class)->except(['index', 'destroy']);
