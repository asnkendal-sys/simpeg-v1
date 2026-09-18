<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/kenaikanpangkat/penetapannominatifkp', 'App\Modules\kenaikanpangkat\penetapannominatifkp\Controllers\PenetapannominatifkpController');

});