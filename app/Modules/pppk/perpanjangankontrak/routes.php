<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/pppk/perpanjangankontrak', 'App\Modules\pppk\perpanjangankontrak\Controllers\PerpanjangankontrakController');

});