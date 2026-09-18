<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/konversidata/referensipendidikan', 'App\Modules\konversidata\referensipendidikan\Controllers\ReferensipendidikanController');

});