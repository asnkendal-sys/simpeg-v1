<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/nominatifantarskpd', 'App\Modules\emutasi\nominatifantarskpd\Controllers\NominatifantarskpdController');

});