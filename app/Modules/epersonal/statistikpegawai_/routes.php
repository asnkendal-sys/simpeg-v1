<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/statistikpegawai', 'App\Modules\epersonal\statistikpegawai\Controllers\StatistikpegawaiController');

});