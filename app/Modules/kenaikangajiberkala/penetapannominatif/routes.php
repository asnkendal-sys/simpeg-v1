<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/kenaikangajiberkala/penetapannominatif', 'App\Modules\kenaikangajiberkala\penetapannominatif\Controllers\PenetapannominatifController');

});