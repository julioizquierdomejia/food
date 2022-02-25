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
    Route::resource('offer', Offercontroller::class);
    Route::resource('raffle', RaffleController::class);
    Route::resource('slider', SliderController::class);
    Route::resource('users', UserController::class);

    Route::resource('dishes', DishController::class);
    Route::resource('menus', MenuController::class);


});

Route::get('/', function () {
    return redirect('/admin/');
});
