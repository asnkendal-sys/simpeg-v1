<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/konversidata/riwayatpangkat', 'App\Modules\konversidata\riwayatpangkat\Controllers\RiwayatpangkatController');

});