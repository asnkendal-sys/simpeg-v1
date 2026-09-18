<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/antarskpd', 'App\Modules\emutasi\antarskpd\Controllers\AntarskpdController');

});