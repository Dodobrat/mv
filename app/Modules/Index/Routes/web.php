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

Route::group(['middleware' => ['web']], function () {
    Route::group([
        'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale()
    ], function () {

        Route::get('/', [
            'as' => 'index',
            'uses' => 'IndexController@index',
        ]);

        Route::post('/', [
            'as' => 'index',
            'uses' => 'IndexController@index',
        ]);
    });
});
