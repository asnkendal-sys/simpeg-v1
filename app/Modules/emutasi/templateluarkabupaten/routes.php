<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/templateluarkabupaten', 'App\Modules\emutasi\templateluarkabupaten\Controllers\TemplateluarkabupatenController');

});