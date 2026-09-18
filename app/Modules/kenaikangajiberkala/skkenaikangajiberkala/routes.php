<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/kenaikangajiberkala/skkenaikangajiberkala', 'App\Modules\kenaikangajiberkala\skkenaikangajiberkala\Controllers\SkkenaikangajiberkalaController');

});