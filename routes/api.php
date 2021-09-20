<?php

use App\Http\Controllers\Api\BusinessController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('users', [UserController::class, 'index']);
    Route::get('info', [UserController::class, 'info'])->middleware(['jwt.auth']);
});

Route::get('home', [HomeController::class, 'index'])->middleware(['jwt.auth']);

Route::group(['prefix' => 'business'], function () {
    Route::get('', [BusinessController::class, 'index'])->middleware(['jwt.auth']);
    Route::get('/category/{category_id}', [BusinessController::class, 'getBusinessByCategory'])->middleware(['jwt.auth']);
    Route::get('/restaurant/country/{country_id}', [BusinessController::class, 'getRestaurantByCountry'])
        ->middleware(['jwt.auth']);
    Route::get('/city/{city_id}', [BusinessController::class, 'getBusinessByCity'])->middleware(['jwt.auth']);
    Route::get('/{business_id}', [BusinessController::class, 'getBusinessById'])->middleware(['jwt.auth']);
});
