<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/mekanismepegawai', 'App\Modules\epersonal\mekanismepegawai\Controllers\MekanismepegawaiController');

});