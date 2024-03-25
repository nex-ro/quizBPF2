<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/posts', [App\Http\Controllers\Api\PostController::class,'index'])->middleware('auth:sanctum','hak-akses:admin');
Route::get('/posts/:id', [App\Http\Controllers\Api\PostController::class,'show'])->middleware('auth:sanctum');
