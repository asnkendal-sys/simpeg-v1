<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/kenaikanpangkat/penetapannonnominatifkp', 'App\Modules\kenaikanpangkat\penetapannonnominatifkp\Controllers\PenetapannonnominatifkpController');

});