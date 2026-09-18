<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/pengangkatanpelaksana', 'App\Modules\emutasi\pengangkatanpelaksana\Controllers\PengangkatanpelaksanaController');

});