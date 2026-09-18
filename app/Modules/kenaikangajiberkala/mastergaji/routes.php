<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/kenaikangajiberkala/mastergaji', 'App\Modules\kenaikangajiberkala\mastergaji\Controllers\MastergajiController');

});