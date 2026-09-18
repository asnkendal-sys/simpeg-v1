<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/pengumuman', 'App\Modules\administrator\pengumuman\Controllers\PengumumanController');

});