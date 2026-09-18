<?php 
Route::group(['middleware' => 'auth'], function () {
    Route::controller('/settings/users', 'App\Modules\settings\users\Controllers\UsersController');    
});
