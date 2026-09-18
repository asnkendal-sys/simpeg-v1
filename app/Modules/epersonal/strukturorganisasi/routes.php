<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/strukturorganisasi', 'App\Modules\epersonal\strukturorganisasi\Controllers\StrukturorganisasiController');

});