<?php

Route::group(['middleware' => 'auth'], function(){

Route::controller('/administrator/tugasgurudosen', 'App\Modules\administrator\tugasgurudosen\Controllers\TugasgurudosenController');

});