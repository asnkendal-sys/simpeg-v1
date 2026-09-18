<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/unitkerja', 'App\Modules\administrator\unitkerja\Controllers\UnitkerjaController');

});