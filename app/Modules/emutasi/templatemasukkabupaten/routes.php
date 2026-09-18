<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/templatemasukkabupaten', 'App\Modules\emutasi\templatemasukkabupaten\Controllers\TemplatemasukkabupatenController');

});