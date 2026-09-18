<?php
Route::group(['middleware' => 'auth'], function () {
    Route::controller('/settings/permissionsmatrix', 'App\Modules\settings\permissionsmatrix\Controllers\PermissionsmatrixController');
});