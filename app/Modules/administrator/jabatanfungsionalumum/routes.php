<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/jabatanfungsionalumum', 'App\Modules\administrator\jabatanfungsionalumum\Controllers\JabatanfungsionalumumController');

});