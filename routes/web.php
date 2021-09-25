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

    /**
     *  Business Gallery
     */
    Route::resource('business', 'BusinessController');
    Route::get('business_gallery/{business}/detail', 'BusinessController@businessGallery')
        ->name('business_gallery.detail');
    Route::post('business_gallery', 'BusinessController@saveBusinessGallery')
        ->name('business_gallery.save');
    Route::delete('business_gallery/{image}', 'BusinessController@deleteBusinessGallery')
        ->name('business_gallery.delete');

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
