<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epensiun/templateskpensiun', 'App\Modules\epensiun\templateskpensiun\Controllers\TemplateskpensiunController');

});