<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/nominatifluarkabupaten', 'App\Modules\emutasi\nominatifluarkabupaten\Controllers\NominatifluarkabupatenController');

});