<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epensiun/penjagaanusulan', 'App\Modules\epensiun\penjagaanusulan\Controllers\PenjagaanusulanController');

});