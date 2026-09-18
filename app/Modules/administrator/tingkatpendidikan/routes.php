<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/tingkatpendidikan', 'App\Modules\administrator\tingkatpendidikan\Controllers\TingkatpendidikanController');

});