<?php

Route::group(['middleware' => 'auth'], function(){

    Route::controller('/administrator/sistemnotifikasi', 'App\Modules\administrator\sistemnotifikasi\Controllers\SistemnotifikasiController');

});