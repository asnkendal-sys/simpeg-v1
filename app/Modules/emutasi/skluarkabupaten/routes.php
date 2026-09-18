<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/skluarkabupaten', 'App\Modules\emutasi\skluarkabupaten\Controllers\SkluarkabupatenController');

});