<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/konversidata/konversicpns', 'App\Modules\konversidata\konversicpns\Controllers\KonversicpnsController');

});