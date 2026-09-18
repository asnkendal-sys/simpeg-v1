<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/webservices/skp', 'App\Modules\webservices\skp\Controllers\SkpController');

});