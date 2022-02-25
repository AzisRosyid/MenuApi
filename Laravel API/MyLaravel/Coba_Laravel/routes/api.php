<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderHeaderController;

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

Route::resource('menus', MenuController::class);
Route::get('menus/search/{search}', [MenuController::class, 'search']);
Route::resource('users', UserController::class);
Route::post('login', [UserController::class, 'login']);
Route::resource('orderheaders', OrderHeaderController::class);
Route::resource('orderdetails', OrderDetailController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
