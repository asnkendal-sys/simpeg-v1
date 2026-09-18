<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/manajemenuser', 'App\Modules\administrator\manajemenuser\Controllers\ManajemenuserController');

});