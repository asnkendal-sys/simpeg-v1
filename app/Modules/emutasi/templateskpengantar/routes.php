<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/templateskpengantar', 'App\Modules\emutasi\templateskpengantar\Controllers\TemplateskpengantarController');

});