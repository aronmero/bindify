<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommercesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\FollowersController;
use App\Http\Controllers\HashtagsController;
use App\Http\Controllers\SearchController;
use App\Models\Follower;
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


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('commerce', CommercesController::class)->except(['index', 'destroy']);
    Route::apiResource('customer', CustomersController::class)->except(['index', 'destroy']);
// Route::apiResource('post', PostsController::class)->except(['index']);
// Route::apiResource('comment', CommentsController::class)->except(['index']);
// Route::apiResource('review', ReviewsController::class)->except(['index']);
    Route::apiResource('hashtag', HashtagsController::class)->except(['show', 'update', 'destroy']);
// Route::apiResource('municipality', MunicipalitiesController::class)->except(['show', 'update', 'destroy', 'store']);
// Route::apiResource('category', CategoriesController::class)->except(['show', 'update', 'destroy', 'store']);
// Route::apiResource('post_type', Post_typesController::class)->except(['show', 'update', 'destroy', 'store']);
// Route::apiResource('notification', NotificationsController::class)->except(['index', 'destroy']);
    Route::get('follower', [FollowersController::class , 'showFollowers']);
    Route::post('follow/{id}', [FollowersController::class , 'follow']);
    Route::get('follows', [FollowersController::class , 'showFollows']);
    Route::get('commerces/{municipity}', [SearchController::class, 'commercesByMunicipality']);
    Route::get('commerces/hashtag/{hashtag}', [SearchController::class, 'commercesByHashtag']);
    Route::get('posts/{idMunicipity}', [SearchController::class, 'postsByMunicipity']);
    Route::get('posts/hashtag/{hashtag}', [SearchController::class, 'postsByMunicipity']);

});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
