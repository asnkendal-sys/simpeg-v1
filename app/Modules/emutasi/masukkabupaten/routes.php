<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/masukkabupaten', 'App\Modules\emutasi\masukkabupaten\Controllers\MasukkabupatenController');

});