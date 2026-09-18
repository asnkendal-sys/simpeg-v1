<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/kenaikangajiberkala/templatesk', 'App\Modules\kenaikangajiberkala\templatesk\Controllers\TemplateskController');

});