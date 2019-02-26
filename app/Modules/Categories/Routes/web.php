<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//Route::group(['prefix' => 'categories'], function () {
//    Route::get('/', function () {
//        dd('This is the Categories module index page. Build something great!');
//    });
//});


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    //'middleware' => \Administration::routeMiddleware()
], function () {
    Route::group([
        'prefix' => 'categories',
        'as' => 'categories.'
    ], function () {

        Route::post('/ajax/getSubCategories', [
            'as' => 'getSubCategories',
            'uses' => 'CategoriesController@getSubCategories'
        ]);

        Route::post('/ajax/getProjects', [
            'as' => 'getProjects',
            'uses' => 'CategoriesController@getProjects'
        ]);

    });
});
