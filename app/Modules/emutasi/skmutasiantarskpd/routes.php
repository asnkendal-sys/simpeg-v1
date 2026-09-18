<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/skmutasiantarskpd', 'App\Modules\emutasi\skmutasiantarskpd\Controllers\SkmutasiantarskpdController');

});