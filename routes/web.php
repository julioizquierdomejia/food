<?php

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

/*
|------------------------------------------------------------------------------------
| Admin
|------------------------------------------------------------------------------------
*/
Route::group(['prefix' => ADMIN, 'as' => ADMIN . '.', 'middleware' => ['auth', 'Role:10']], function () {
//    Route::get('/', 'DashboardController@index')->name('dash');
    Route::get('/', 'RaffleWinnersController@index')->name('dash');
    Route::resource('users', 'UserController');
    Route::resource('carousel', 'CarouselController');
    Route::resource('categories', 'CategoriesController');
    Route::resource('items', 'ItemsController');
    Route::resource('raffles', 'RafflesController');
    Route::resource('sales', 'SalesController');

    //Para re ordenar rifas
    Route::post('reorder_raffles', [App\Http\Controllers\RafflesController::class, 'update_order_raffles'])->name('reorder');

    Route::get('winner/{id}', 'RaffleWinnersController@raffleDraw')->name('getwinner');
    Route::post('winner', 'RaffleWinnersController@uploadPhoto')->name('photowinner');
    /**
     * Notifications
     */
    Route::resource('notifications', 'NotificationsController');
    Route::post('notify', 'NotificationsController@notify')
        ->name('notifications.notify');
});

Route::get('/', function () {
    return redirect('/admin/');
});
