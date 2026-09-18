<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/pppk/templateskpppk', 'App\Modules\pppk\templateskpppk\Controllers\TemplateskpppkController');

});