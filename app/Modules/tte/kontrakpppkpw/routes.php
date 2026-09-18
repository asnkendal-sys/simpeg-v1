<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/tte/kontrakpppkpw', 'App\Modules\tte\kontrakpppkpw\Controllers\KontrakpppkpwController');

});