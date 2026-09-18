<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/kenaikanpangkat/rekapusulankenaikanpangkat', 'App\Modules\kenaikanpangkat\rekapusulankenaikanpangkat\Controllers\RekapusulankenaikanpangkatController');

});