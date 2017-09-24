<?php

Route::post('/login', 'AuthenticateController@authenticate');


Route::group(['prefix'=>'v1','middleware' => ['before' => 'jwt.auth']],function(){

    Route::resource('caller', 'CallerController');
    Route::get('caller/{id}/notes','CallerController@notes');
    Route::post('caller/{id}/notes','CallerController@addNotes');
    Route::post('caller/{id}/phone','CallerController@addPhone');
    Route::get('caller/{id}/programmes','CallerController@programmes');


    Route::resource('/phone-number', 'PhoneNumberController');
    Route::get('phone-number/{phone_number}/caller','PhoneNumberController@caller');

    Route::resource('/call', 'CallController');

    Route::resource('/programme', 'ProgrammeController');


    Route::get('app','AppController@index');
    Route::get('app/settings','AppController@getSettings');
    Route::post('app/settings','AppController@settings');



});
