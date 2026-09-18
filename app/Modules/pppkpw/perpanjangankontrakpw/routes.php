<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/pppkpw/perpanjangankontrakpw', 'App\Modules\pppkpw\perpanjangankontrakpw\Controllers\PerpanjangankontrakpwController');

});