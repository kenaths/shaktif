<?php

use Illuminate\Http\Request;

Route::post('/login', 'AuthenticateController@authenticate');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
