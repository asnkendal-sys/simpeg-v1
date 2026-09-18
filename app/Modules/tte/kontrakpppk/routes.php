<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/tte/kontrakpppk', 'App\Modules\tte\kontrakpppk\Controllers\KontrakpppkController');

});