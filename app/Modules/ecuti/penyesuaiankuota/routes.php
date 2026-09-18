<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/ecuti/penyesuaiankuota', 'App\Modules\ecuti\penyesuaiankuota\Controllers\PenyesuaiankuotaController');

});