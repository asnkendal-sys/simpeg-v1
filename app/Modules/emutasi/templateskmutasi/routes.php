<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/templateskmutasi', 'App\Modules\emutasi\templateskmutasi\Controllers\TemplateskmutasiController');

});