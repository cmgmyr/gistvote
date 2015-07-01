<?php

Route::get('/', ['as' => 'home', 'uses' =>'GistsController@index']);

// Gists
Route::get('{username}/{id}', ['as' => 'gists.show', 'uses' =>'GistsController@show']);
Route::post('{username}/{id}', ['as' => 'gists.store', 'uses' =>'GistsController@store']);
Route::get('refresh', ['as' => 'gists.refresh', 'uses' =>'GistsController@refresh']);

// API-ish stuff, excluded from CSRF validation. @todo: maybe find a better solution
Route::group(['prefix' => 'api'], function () {
    Route::patch('gists/{id}/activate', 'GistsController@activateGist');
    Route::patch('gists/{id}/deactivate', 'GistsController@deactivateGist');
});

// Authentication
Route::get('login', ['as' => 'login', 'uses' =>'AuthController@login']);
Route::get('logout', ['as' => 'logout', 'uses' =>'AuthController@logout']);
