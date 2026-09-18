<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/dukpegawai', 'App\Modules\epersonal\dukpegawai\Controllers\DukpegawaiController');

});