<?php 
Route::group(['middleware' => 'auth'], function () {
    Route::controller('/developer/context', 'App\Modules\developer\context\Controllers\ContextController');
});


