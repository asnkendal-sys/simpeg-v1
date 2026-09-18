<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epensiun/penjagaanpensiun', 'App\Modules\epensiun\penjagaanpensiun\Controllers\PenjagaanpensiunController');

});