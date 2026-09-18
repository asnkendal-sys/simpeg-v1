<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epensiun/unduhdokumendpcp', 'App\Modules\epensiun\unduhdokumendpcp\Controllers\UnduhdokumendpcpController');

});