<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/nominatifpenjagaankp', 'App\Modules\epersonal\nominatifpenjagaankp\Controllers\NominatifpenjagaankpController');

});