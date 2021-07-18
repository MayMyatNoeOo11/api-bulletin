<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

/**
 * Show Posts Page
 */
Route::get('/', [PostController::class, 'showAllPosts'])->name('showAllPosts');

//Route::get('/logins', [UserController::class,'index'])->name('index');

//Route::resource('/tests','App\Http\Controllers\TestController');
Route::get('post/export',[PostController::class,'export'])->name('post.export');
Route::get('/post/show/{id}',[PostController::class,'show'])->name('post.show');
//Auth Routes
Route::group(['middleware' => ['prevent-back-history','auth']], function(){
    Route::get('/common',[UserController::class,'common'])->name('common');
    Route::get('/post/create',[PostController::class,'create'])->name('post.create');
    Route::post('/post/createConfirm',[PostController::class,'createConfirm'])->name('post.createConfirm');
    Route::post('/post/store',[PostController::class,'store'])->name('post.store');
    Route::get('/post/edit/{id}',[PostController::class,'edit'])->name('post.edit');
    Route::post('/post/updateConfirm/{id}',[PostController::class,'updateConfirm'])->name('post.updateConfirm');
    Route::post('/post/update/{post}',[PostController::class,'update'])->name('post.update');
    Route::get('/post/delete/{id}',[PostController::class,'delete'])->name('post.delete');
    Route::post('/post/delete-post',[PostController::class,'destroy'])->name('post.destroy');
     
    
    Route::get('/user/edit/{id?}',[UserController::class,'edit'])->name('user.edit');
    Route::post('/user/edit-confrim/{id}',[UserController::class,'updateConfirm'])->name('user.updateConfirm');
    Route::post('/user/update/{user}',[UserController::class,'update'])->name('user.update');
    Route::get('/user/profile/{id}',[UserController::class,'profile'])->name('user.profile');
    Route::get('/user/change-password/{id}',[UserController::class,'changePasswordForm'])->name('user.changePasswordForm');
    Route::post('/user/change-password',[UserController::class,'changePassword'])->name('user.changePassword');
    
    
});
Route::group(['middleware' => ['prevent-back-history','auth','verify.admin']], function(){
    Route::get('/user/all-user',[UserController::class,'index'])->name('showAllUsers');
    Route::get('/user/show/{id}',[UserController::class,'show'])->name('user.show');
    
    Route::get('/user/create',[UserController::class,'create'])->name('user.create');
    Route::post('/user/create-user',[UserController::class,'createConfirm'])->name('user.createConfirm');
    Route::post('/user/confirm-user',[UserController::class,'store'])->name('user.store');


    Route::get('/user/delete/{id}',[UserController::class,'delete'])->name('user.delete');
    Route::post('/user/delete-user',[UserController::class,'destroy'])->name('user.destroy');

  
    Route::get('/post/import-form',[PostController::class,'importForm'])->name('post.importForm');
    Route::post('/post/import',[PostController::class,'import'])->name('post.import');

    


});




