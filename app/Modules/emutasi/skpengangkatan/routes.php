<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/skpengangkatan', 'App\Modules\emutasi\skpengangkatan\Controllers\SkpengangkatanController');

});