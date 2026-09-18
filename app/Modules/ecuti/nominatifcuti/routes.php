<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/ecuti/nominatifcuti', 'App\Modules\ecuti\nominatifcuti\Controllers\NominatifcutiController');

});