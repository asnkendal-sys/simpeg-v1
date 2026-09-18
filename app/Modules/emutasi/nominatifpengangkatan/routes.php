<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/nominatifpengangkatan', 'App\Modules\emutasi\nominatifpengangkatan\Controllers\NominatifpengangkatanController');

});