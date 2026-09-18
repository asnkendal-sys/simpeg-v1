<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/dalamskpd', 'App\Modules\emutasi\dalamskpd\Controllers\DalamskpdController');

});