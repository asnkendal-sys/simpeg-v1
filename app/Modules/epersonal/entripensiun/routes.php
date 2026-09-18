<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/entripensiun', 'App\Modules\epersonal\entripensiun\Controllers\EntripensiunController');

});