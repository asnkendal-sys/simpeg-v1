<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/utility', 'App\Modules\administrator\utility\Controllers\UtilityController');

});