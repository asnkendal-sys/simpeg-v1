<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/imageslider', 'App\Modules\administrator\imageslider\Controllers\ImagesliderController');

});