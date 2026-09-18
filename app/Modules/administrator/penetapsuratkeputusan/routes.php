<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/penetapsuratkeputusan', 'App\Modules\administrator\penetapsuratkeputusan\Controllers\PenetapsuratkeputusanController');

});