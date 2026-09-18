<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/konversidata/riwayatpppk', 'App\Modules\konversidata\riwayatpppk\Controllers\RiwayatpppkController');

});