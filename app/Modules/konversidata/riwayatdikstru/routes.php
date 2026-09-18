<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/konversidata/riwayatdikstru', 'App\Modules\konversidata\riwayatdikstru\Controllers\RiwayatdikstruController');

});