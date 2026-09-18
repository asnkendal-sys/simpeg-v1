<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/konversidata/riwayatpendidikan', 'App\Modules\konversidata\riwayatpendidikan\Controllers\RiwayatpendidikanController');

});