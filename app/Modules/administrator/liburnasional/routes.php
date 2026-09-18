<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/liburnasional', 'App\Modules\administrator\liburnasional\Controllers\LiburnasionalController');

});