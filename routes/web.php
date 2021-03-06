<?php

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

//
//use App\Http\Offercontroller;

/*
|------------------------------------------------------------------------------------
| Admin
|------------------------------------------------------------------------------------
*/
Route::group(['prefix' => ADMIN, 'as' => ADMIN . '.', 'middleware' => ['auth', 'Role:1']], function () {

    Route::get('/', 'DashboardController@index')->name('dash');
    Route::resource('users', UserController::class);

    Route::resource('dishes', DishController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('stalls', StallController::class);
    Route::resource('areas', AreaController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('config', ParameterController::class);

    //rutas para el consumo y ajax
    Route::get('consumo', [\App\Http\Controllers\OrderController::class, 'consumo'])->name('orders.consumo');


});

Route::post('menu/updateStatus', [\App\Http\Controllers\MenuController::class, 'updateStatus'])->name('menu.updateStatus');
Route::post('menu/getMenu', [\App\Http\Controllers\MenuController::class, 'getMenu'])->name('menu.getMenu');

Route::post('area/updateStatus', [\App\Http\Controllers\AreaController::class, 'updateStatus'])->name('area.updateStatus');
Route::post('cargo/updateStatus', [\App\Http\Controllers\StallController::class, 'updateStatus'])->name('cargo.updateStatus');
Route::post('user/updateStatus', [\App\Http\Controllers\UserController::class, 'updateStatus'])->name('user.updateStatus');

Route::get('/', function () {
    return redirect('/admin/');
});
