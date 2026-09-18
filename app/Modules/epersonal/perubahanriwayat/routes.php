<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/perubahanriwayat', 'App\Modules\epersonal\perubahanriwayat\Controllers\PerubahanriwayatController');

});