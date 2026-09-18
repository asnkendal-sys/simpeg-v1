<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/rekapkenaikanpangkat', 'App\Modules\epersonal\rekapkenaikanpangkat\Controllers\RekapkenaikanpangkatController');

});