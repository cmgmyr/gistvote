<?php

Route::get('/', ['as' => 'home', 'uses' =>'GistsController@index']);

// Gists
Route::group(['prefix' => 'gists'], function () {
    Route::get('refresh', ['as' => 'gists.refresh', 'uses' =>'GistsController@refresh']);
});

// Authentication
Route::get('login', ['as' => 'login', 'uses' =>'AuthController@login']);
Route::get('logout', ['as' => 'logout', 'uses' =>'AuthController@logout']);
