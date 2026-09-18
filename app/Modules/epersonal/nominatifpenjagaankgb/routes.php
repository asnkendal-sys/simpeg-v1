<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/nominatifpenjagaankgb', 'App\Modules\epersonal\nominatifpenjagaankgb\Controllers\NominatifpenjagaankgbController');

});