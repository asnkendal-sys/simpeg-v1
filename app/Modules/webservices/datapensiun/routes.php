<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/webservices/datapensiun', 'App\Modules\webservices\datapensiun\Controllers\DatapensiunController');

});