<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/biodata', 'App\Modules\epersonal\biodata\Controllers\BiodataController');

});