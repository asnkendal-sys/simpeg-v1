<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/jabatannonjabatan', 'App\Modules\administrator\jabatannonjabatan\Controllers\JabatannonjabatanController');

});