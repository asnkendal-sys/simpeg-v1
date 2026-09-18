<?php

Route::group(['middleware' => 'auth'], function(){
    
    Route::controller('/epensiun/uploadskpensiun', 'App\Modules\epensiun\uploadskpensiun\Controllers\UploadskpensiunController');
    
});

