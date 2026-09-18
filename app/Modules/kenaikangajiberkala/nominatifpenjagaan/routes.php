<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/kenaikangajiberkala/nominatifpenjagaan', 'App\Modules\kenaikangajiberkala\nominatifpenjagaan\Controllers\NominatifpenjagaanController');

});