<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epensiun/usulpensiun', 'App\Modules\epensiun\usulpensiun\Controllers\UsulpensiunController');

});