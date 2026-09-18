<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epensiun/cetakdpcp', 'App\Modules\epensiun\cetakdpcp\Controllers\CetakdpcpController');

});