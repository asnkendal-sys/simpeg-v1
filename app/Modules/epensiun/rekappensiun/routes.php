<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epensiun/rekappensiun', 'App\Modules\epensiun\rekappensiun\Controllers\RekappensiunController');

});