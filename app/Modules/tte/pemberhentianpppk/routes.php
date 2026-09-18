<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/tte/pemberhentianpppk', 'App\Modules\tte\pemberhentianpppk\Controllers\PemberhentianpppkController');

});