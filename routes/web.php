<?php

use App\Http\Controllers\PayPalController;

Route::get('/', function () {
    return view('index');
});

Route::post('checkout', 'PayPalController@checkout')->name('checkout');

