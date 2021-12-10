<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\AdController;

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


Route::group(['prefix' => 'v1'], function () {

      //Categories CRUD

      Route::get('categories', [CategoryController::class, 'index']);
      Route::get('category/{id}', [CategoryController::class, 'show']);
      Route::post('category', [CategoryController::class, 'create']);
      Route::post('category/{id}', [CategoryController::class, 'update']);
      Route::delete('category/{id}', [CategoryController::class, 'destroy']);

      //Tags CRUD

      Route::get('tags', [TagController::class, 'index']);
      Route::get('tag/{id}', [TagController::class, 'show']);
      Route::post('tag', [TagController::class, 'create']);
      Route::post('tag/{id}', [TagController::class, 'update']);
      Route::delete('tag/{id}', [TagController::class, 'destroy']);

      //Ads CRUD

      Route::get('ads', [AdController::class, 'index']); // get all ads with tag, category and advertiser filter
      Route::get('ad/{id}', [AdController::class, 'show']);
      Route::post('ad', [AdController::class, 'create']);
      Route::post('ad/{id}', [AdController::class, 'update']);
      Route::delete('ad/{id}', [AdController::class, 'destroy']);

});
