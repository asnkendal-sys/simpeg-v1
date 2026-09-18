<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/templateskpengangkatan', 'App\Modules\emutasi\templateskpengangkatan\Controllers\TemplateskpengangkatanController');

});