<?php

Route::post('/login', 'AuthenticateController@authenticate');


Route::group(['prefix'=>'v1','middleware' => ['before' => 'jwt.auth']],function(){

    Route::resource('/caller', 'CallerController');

    Route::resource('/phone-number', 'PhoneNumberController');
    Route::get('phone-number/{id}/caller','CallerController@caller');




});
