<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/tugasdokter', 'App\Modules\administrator\tugasdokter\Controllers\TugasdokterController');

});