<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);
Route::apiResource('/posts/:id', App\Http\Controllers\Api\PostController::class);

Route::apiResource('/mhs', App\Http\Controllers\Api\Mhs_nim::class);
// Route::apiResource('/mhs/:id', App\Http\Controllers\Api\Mhs_nim::class);

Route::post('login', [App\Http\Controllers\Api\AuthController::class,'signin']);
Route::post('register', [App\Http\Controllers\Api\AuthController::class,'signup']);


