<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/konversidata/riwayatgolongan', 'App\Modules\konversidata\riwayatgolongan\Controllers\RiwayatgolonganController');

});