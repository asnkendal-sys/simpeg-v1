<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/skmasukkabupaten', 'App\Modules\emutasi\skmasukkabupaten\Controllers\SkmasukkabupatenController');

});