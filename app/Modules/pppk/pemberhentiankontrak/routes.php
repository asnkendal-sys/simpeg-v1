<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/pppk/pemberhentiankontrak', 'App\Modules\pppk\pemberhentiankontrak\Controllers\PemberhentiankontrakController');

});