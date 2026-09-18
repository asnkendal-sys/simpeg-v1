<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/webservices/riwayatdiklat', 'App\Modules\webservices\riwayatdiklat\Controllers\RiwayatdiklatController');

});