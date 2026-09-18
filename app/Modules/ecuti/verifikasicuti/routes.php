<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/ecuti/verifikasicuti', 'App\Modules\ecuti\verifikasicuti\Controllers\VerifikasicutiController');

});