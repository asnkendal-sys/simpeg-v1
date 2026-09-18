<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/emutasi/luarkabupaten', 'App\Modules\emutasi\luarkabupaten\Controllers\LuarkabupatenController');

});