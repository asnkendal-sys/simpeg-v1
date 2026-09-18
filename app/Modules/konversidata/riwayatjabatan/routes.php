<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/konversidata/riwayatjabatan', 'App\Modules\konversidata\riwayatjabatan\Controllers\RiwayatjabatanController');

});