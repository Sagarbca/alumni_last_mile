<?php

use Illuminate\Database\Connection;
use Illuminate\Support\Facades;
Route::get('/', function () {
    // Test database connection
    /*if (Facades\DB::connection()->getDatabaseName())
    {
        return 'Connected to the DB: ' . Facades\DB::connection()->getDatabaseName();
    }*/
    return view('welcome');
});



/*Route::group(['middleware' => 'auth:api'], function()
{
    Route::post('details', 'UserController@details');
});*/
