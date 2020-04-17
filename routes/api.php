<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'v1'], function () {

    Route::post('login', 'UserController@login');
    Route::post('signup', 'UserController@register');

    Route::group(['middleware' => 'auth:api'], function() {

        Route::get('details', 'UserController@details');
        Route::post('changePassword', 'Auth\ChangePasswordController@create');
        Route::group(['prefix' => 'student'],function (){
            Route::get('/', 'studentController@index');
            Route::post('/create', 'studentController@store');
            Route::get('/{id}', 'studentController@show');
            Route::post('/{id}', 'studentController@update');

        });

        Route::group(['prefix' => 'password'],function (){
            Route::post('/create', 'Auth\ResetPasswordController@create');
            Route::get('/find/{token}', 'Auth\ResetPasswordController@find');
            Route::post('/reset', 'Auth\ResetPasswordController@reset');
        });
    });

    Route::get('user_detail','UserController@details');
    Route::get('user_detail/{id}','UserController@userDetailById');

    //post
    Route::group(['prefix' => 'post'],function (){
        Route::get('/', 'Post\PostController@index');
        Route::post('/create', 'Post\PostController@store');
        Route::get('/{id}', 'Post\PostController@show');
        Route::post('/{id}', 'Post\PostController@update');
   });
});


/*Route::group(['namespace' => 'Auth', 'middleware' => 'auth:api', 'prefix' => 'password'], function () {
    Route::post('create', 'ResetPasswordController@create');
    Route::get('find/{token}', 'ResetPasswordController@find');
    Route::post('reset', 'ResetPasswordController@reset');
});*/

/*Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::group(['middleware' => 'auth:api'], function()
{

    Route::post('details', [ 'as' => 'details', 'uses' => 'UserController@details']);
});*/
