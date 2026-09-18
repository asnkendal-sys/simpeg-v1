<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/pppk/pengangkatankontrak', 'App\Modules\pppk\pengangkatankontrak\Controllers\PengangkatankontrakController');

});