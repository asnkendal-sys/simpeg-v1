<?php
Route::group(['middleware' => 'auth'], function () {
    Route::controller('/settings/roles', 'App\Modules\settings\roles\Controllers\RolesController');
});