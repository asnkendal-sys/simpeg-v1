<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/ecuti/rekapcuti', 'App\Modules\ecuti\rekapcuti\Controllers\RekapcutiController');

});