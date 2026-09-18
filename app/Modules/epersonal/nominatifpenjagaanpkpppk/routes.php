<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/nominatifpenjagaanpkpppk', 'App\Modules\epersonal\nominatifpenjagaanpkpppk\Controllers\NominatifpenjagaanpkpppkController');

});