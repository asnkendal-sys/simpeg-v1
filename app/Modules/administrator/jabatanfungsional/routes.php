<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/jabatanfungsional', 'App\Modules\administrator\jabatanfungsional\Controllers\JabatanfungsionalController');

});