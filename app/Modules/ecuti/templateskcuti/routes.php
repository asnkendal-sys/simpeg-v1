<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/ecuti/templateskcuti', 'App\Modules\ecuti\templateskcuti\Controllers\TemplateskcutiController');

});