<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/biodatapegawai', 'App\Modules\epersonal\biodatapegawai\Controllers\BiodatapegawaiController');

});