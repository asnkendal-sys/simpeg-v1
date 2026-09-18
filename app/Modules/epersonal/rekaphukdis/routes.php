<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/rekaphukdis', 'App\Modules\epersonal\rekaphukdis\Controllers\RekaphukdisController');

});