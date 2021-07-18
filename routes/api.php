<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['middleware' => ['cors', 'json.response']], function(){
    Route::get('/posts', 'PostApiController@showAllPosts'); 
    Route::get('/post/{id}', 'PostApiController@show');
    Route::get('/users/{id}','UserApiController@index');
    Route::get('/user/profile/{id}','UserApiController@show');
    Route::get('/post/edit/{id}', 'PostApiController@edit');
    Route::get('/user/edit/{id}', 'UserApiController@edit');
   
    Route::post('/user/createConfirm','UserApiController@createConfirm');
    Route::post('/post/createConfirm','PostApiController@createConfirm');
    Route::post('/post/updateConfirm','PostApiController@updateConfirm');
    Route::post('/user/updateConfirm','UserApiController@updateConfirm');
    Route::post('/post/store','PostApiController@store');
    Route::post('/user/store','UserApiController@store');
    Route::post('/post/update','PostApiController@update');
    Route::post('/user/update','UserApiController@update');
    Route::post('/post/destroy','PostApiController@destroy');
    Route::post('/user/destroy','UserApiController@destroy');
    Route::get('/user/checkDelete/{id}','UserApiController@checkDelete');
    Route::post('/user/search','UserApiController@search');
    Route::post('/user/changePassword','UserApiController@changePassword');
    Route::get('/post/export','PostApiController@export');
    Route::post('/post/import','PostApiController@import');
    // Route::post('/login','UserApiController@login');
    // Route::post('/logout','UserApiController@logout');

      // public routes
      Route::post('/auth/login', 'AuthApiController@login')->name('login.api');
      Route::post('/auth/register','AuthApiController@register')->name('register.api');    
  
      Route::post('/auth/logout', 'AuthApiController@logout')->name('logout.api');
});
Route::middleware('auth:api')->group(function () {
    // our routes to be protected will go in here
   
});
