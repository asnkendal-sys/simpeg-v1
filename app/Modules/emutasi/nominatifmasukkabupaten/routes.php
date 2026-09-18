<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/nominatifmasukkabupaten', 'App\Modules\emutasi\nominatifmasukkabupaten\Controllers\NominatifmasukkabupatenController');

});