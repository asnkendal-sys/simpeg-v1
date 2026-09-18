<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/kenaikanpangkat/penjagaankenaikanpangkat', 'App\Modules\kenaikanpangkat\penjagaankenaikanpangkat\Controllers\PenjagaankenaikanpangkatController');

});