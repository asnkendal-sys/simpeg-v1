<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/nominatifpenjagaanpensiun', 'App\Modules\epersonal\nominatifpenjagaanpensiun\Controllers\NominatifpenjagaanpensiunController');

});