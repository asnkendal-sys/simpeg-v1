<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/urutanjabatanpegawai', 'App\Modules\epersonal\urutanjabatanpegawai\Controllers\UrutanjabatanpegawaiController');

});