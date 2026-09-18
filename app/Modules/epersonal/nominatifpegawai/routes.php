<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/nominatifpegawai', 'App\Modules\epersonal\nominatifpegawai\Controllers\NominatifpegawaiController');

});