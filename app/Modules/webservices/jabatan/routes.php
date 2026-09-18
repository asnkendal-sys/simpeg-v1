<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/webservices/jabatan', 'App\Modules\webservices\jabatan\Controllers\JabatanController');

});