<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PointController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;


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


Route::group(['prefix' => 'auth'], function () {
    Route::post('mobile', [AuthController::class, 'mobile']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'users'], function () {

    Route::put('/{id_user}', [AuthController::class, 'update'])->middleware(['jwt.auth']);

});

Route::group(['prefix' => 'home'], function () {
    Route::get('getMenus', [HomeController::class, 'getMenus'])->middleware(['jwt.auth']);
    Route::get('getHistory', [HomeController::class, 'getHistory'])->middleware(['jwt.auth']);
    Route::post('registerOrder', [HomeController::class, 'registerOrder'])->middleware(['jwt.auth']);
    Route::post('updateStatus', [HomeController::class, 'updateStatus'])->middleware(['jwt.auth']);
    Route::post('cancelOrder', [HomeController::class, 'cancelOrder'])->middleware(['jwt.auth']);
    
});

