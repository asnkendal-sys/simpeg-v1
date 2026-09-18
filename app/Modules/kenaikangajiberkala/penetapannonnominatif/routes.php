<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/kenaikangajiberkala/penetapannonnominatif', 'App\Modules\kenaikangajiberkala\penetapannonnominatif\Controllers\PenetapannonnominatifController');

});