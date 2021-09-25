<?php

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

/*
|------------------------------------------------------------------------------------
| Admin
|------------------------------------------------------------------------------------
*/
Route::group(['prefix' => ADMIN, 'as' => ADMIN . '.', 'middleware' => ['auth', 'Role:10']], function () {
    Route::get('/', 'DashboardController@index')->name('dash');
//    Route::get('/', 'HomeCategoriesController@index')->name('dash');
    Route::resource('users', 'UserController');
    Route::resource('carousel', 'CarouselController');
    Route::resource('categories', 'CategoriesController');
    Route::resource('items', 'ItemsController');
    Route::resource('raffles', 'RafflesController');

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
