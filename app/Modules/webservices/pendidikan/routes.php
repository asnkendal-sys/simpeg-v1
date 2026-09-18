<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/webservices/pendidikan', 'App\Modules\webservices\pendidikan\Controllers\PendidikanController');

});