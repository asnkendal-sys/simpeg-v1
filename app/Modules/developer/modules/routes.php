<?php 
Route::group(['middleware' => 'auth'], function () {
    Route::controller('/developer/modules', 'App\Modules\developer\modules\Controllers\ModulesController');
});


