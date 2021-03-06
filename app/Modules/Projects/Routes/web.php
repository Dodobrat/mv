<?php

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    //'middleware' => \Administration::routeMiddleware()
], function () {
    Route::group([
        'prefix' => 'projects',
        'as' => 'projects.'
    ], function () {

        Route::post('/ajax/getProject', [
            'as' => 'getProject',
            'uses' => 'ProjectsController@getProject'
        ]);
    });
});
