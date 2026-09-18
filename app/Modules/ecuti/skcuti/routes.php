<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/ecuti/skcuti', 'App\Modules\ecuti\skcuti\Controllers\SkcutiController');

});