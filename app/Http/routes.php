<?php

Route::get('/', ['as' => 'home', 'uses' =>'GistsController@index']);

// Gists
Route::group(['prefix' => 'gists'], function () {
    Route::get('refresh', ['as' => 'gists.refresh', 'uses' =>'GistsController@refresh']);
});

// API-ish stuff, excluded from CSRF validation. @todo: maybe find a better solution
Route::group(['prefix' => 'api'], function () {
    Route::patch('gists/{id}/activate', 'GistsController@activateGist');
});

// Authentication
Route::get('login', ['as' => 'login', 'uses' =>'AuthController@login']);
Route::get('logout', ['as' => 'logout', 'uses' =>'AuthController@logout']);
