<?php

Route::group(['middleware' => 'auth'], function(){

	Route::controller('/tte/kenaikangaji', 'App\Modules\tte\kenaikangaji\Controllers\KenaikangajiController');

	Route::post('/tte/kenaikangaji/tte','App\Modules\tte\kenaikangaji\Controllers\KenaikangajiController@postSign');

});