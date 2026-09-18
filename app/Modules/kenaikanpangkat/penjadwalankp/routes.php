<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/kenaikanpangkat/penjadwalankp', 'App\Modules\kenaikanpangkat\penjadwalankp\Controllers\PenjadwalankpController');

});