<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/skmutasidalamskpd', 'App\Modules\emutasi\skmutasidalamskpd\Controllers\SkmutasidalamskpdController');

});