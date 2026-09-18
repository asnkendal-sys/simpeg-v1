<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/sekolahswasta', 'App\Modules\administrator\sekolahswasta\Controllers\SekolahswastaController');

});