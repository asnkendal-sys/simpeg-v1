<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/nominatifpenjagaanulangtahun', 'App\Modules\epersonal\nominatifpenjagaanulangtahun\Controllers\NominatifpenjagaanulangtahunController');

});