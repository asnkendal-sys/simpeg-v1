<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/epersonal/daftarjabatankosong', 'App\Modules\epersonal\daftarjabatankosong\Controllers\DaftarjabatankosongController');

});