<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/kenaikanpangkat/templatekenaikanpangkat', 'App\Modules\kenaikanpangkat\templatekenaikanpangkat\Controllers\TemplatekenaikanpangkatController');

});