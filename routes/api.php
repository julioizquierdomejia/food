<?php



use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomeController;
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
    Route::get('/public/resetpass/{email_user}', [UserController::class, 'sendEmailPassword']);
    Route::post('/public/resetpass', [UserController::class, 'NewPass']);
});

Route::get('home', [HomeController::class, 'index'])->middleware(['jwt.auth']);
Route::get('winners', [HomeController::class, 'winners'])->middleware(['jwt.auth']);

Route::get('category/{id_category}', [HomeController::class, 'items_category'])->middleware(['jwt.auth']);


