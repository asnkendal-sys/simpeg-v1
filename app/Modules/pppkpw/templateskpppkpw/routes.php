<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/pppkpw/templateskpppkpw', 'App\Modules\pppkpw\templateskpppkpw\Controllers\TemplateskpppkpwController');

});