<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/datapegawai', 'App\Modules\epersonal\datapegawai\Controllers\DatapegawaiController');

});