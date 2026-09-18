<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/konversidata/konversipppk', 'App\Modules\konversidata\konversipppk\Controllers\KonversipppkController');

});