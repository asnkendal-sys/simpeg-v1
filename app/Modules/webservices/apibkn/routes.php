<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/webservices/apibkn', 'App\Modules\webservices\apibkn\Controllers\ApibknController');

});