<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/webservices/kolaborasidatataspen', 'App\Modules\webservices\kolaborasidatataspen\Controllers\KolaborasidatataspenController');

});