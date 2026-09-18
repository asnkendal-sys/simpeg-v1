<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/webservices/datadiri', 'App\Modules\webservices\datadiri\Controllers\DatadiriController');

});