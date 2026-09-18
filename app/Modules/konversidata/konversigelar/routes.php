<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/konversidata/konversigelar', 'App\Modules\konversidata\konversigelar\Controllers\KonversigelarController');

});