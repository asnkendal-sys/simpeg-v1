<?php 
Route::group(['middleware' => 'auth'], function () {
    Route::controller('/settings/configurations', 'App\Modules\settings\configurations\Controllers\ConfigurationsController');
});