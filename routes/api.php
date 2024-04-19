<?php

Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/verify', 'Auth\LoginController@verify')->name('verify');
