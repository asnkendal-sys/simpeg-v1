<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/jurusanpendidikan', 'App\Modules\administrator\jurusanpendidikan\Controllers\JurusanpendidikanController');

});