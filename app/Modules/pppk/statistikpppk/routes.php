<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/pppk/statistikpppk', 'App\Modules\pppk\statistikpppk\Controllers\StatistikpppkController');

});