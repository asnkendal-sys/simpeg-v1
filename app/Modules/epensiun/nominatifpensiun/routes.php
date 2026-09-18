<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epensiun/nominatifpensiun', 'App\Modules\epensiun\nominatifpensiun\Controllers\NominatifpensiunController');

});