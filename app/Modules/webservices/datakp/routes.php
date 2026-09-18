<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/webservices/datakp', 'App\Modules\webservices\datakp\Controllers\DatakpController');

});