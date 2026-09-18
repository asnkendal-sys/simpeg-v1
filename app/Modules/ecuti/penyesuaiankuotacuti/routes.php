<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/ecuti/penyesuaiankuotacuti', 'App\Modules\ecuti\penyesuaiankuotacuti\Controllers\PenyesuaiankuotacutiController');

});