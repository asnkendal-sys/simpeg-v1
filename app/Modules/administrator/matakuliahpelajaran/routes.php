<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/matakuliahpelajaran', 'App\Modules\administrator\matakuliahpelajaran\Controllers\MatakuliahpelajaranController');

});