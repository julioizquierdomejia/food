<?php



use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\PaymentController;
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


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('users', [AuthController::class, 'index']);
    Route::get('info', [AuthController::class, 'info'])->middleware(['jwt.auth']);
    Route::post('storeToken', [AuthController::class, 'storeToken'])->middleware(['jwt.auth']);
});

Route::group(['prefix' => 'users'], function () {
    Route::put('/{id_user}', [UserController::class, 'update'])->middleware(['jwt.auth']);
    Route::post('/favorites', [HomeController::class, 'NewFavorite'])->middleware(['jwt.auth']);
    Route::delete('/favorites/{$id_raffle}', [HomeController::class, 'DeleteFavorite'])->middleware(['jwt.auth']);
    Route::get('/public/resetpass/{email_user}', [UserController::class, 'sendEmailPassword']);
    Route::post('/public/resetpass', [UserController::class, 'NewPass']);
});

Route::get('home', [HomeController::class, 'index'])->middleware(['jwt.auth']);
Route::get('detailRaffle/{id_raffle}', [HomeController::class, 'detail'])->middleware(['jwt.auth']);
Route::get('winners', [HomeController::class, 'winners'])->middleware(['jwt.auth']);
Route::get('favoritesRaffles', [HomeController::class, 'favorites'])->middleware(['jwt.auth']);

Route::get('category/{id_category}', [HomeController::class, 'items_category'])->middleware(['jwt.auth']);

Route::post('payment', [PaymentController::class, 'paymentCreate']);
Route::get('payment/verify', [PaymentController::class, 'PyamentValidate']);
Route::get('payment/refused', [PaymentController::class, 'Pyamentrefused']);
Route::get('payment/cancel', [PaymentController::class, 'Pyamentcancel']);
Route::get('payment/error', [PaymentController::class, 'Pyamenterror']);
