<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/perubahanbiodata', 'App\Modules\epersonal\perubahanbiodata\Controllers\PerubahanbiodataController');

});