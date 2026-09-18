<?php 
Route::group(['middleware' => 'auth'], function () {
    Route::controller('/settings/permissions', 'App\Modules\settings\permissions\Controllers\PermissionsController');
});