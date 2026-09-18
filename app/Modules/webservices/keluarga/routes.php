<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/webservices/keluarga', 'App\Modules\webservices\keluarga\Controllers\KeluargaController');

});