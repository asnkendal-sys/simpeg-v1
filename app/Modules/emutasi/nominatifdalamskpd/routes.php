<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/nominatifdalamskpd', 'App\Modules\emutasi\nominatifdalamskpd\Controllers\NominatifdalamskpdController');

});