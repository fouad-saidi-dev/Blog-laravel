<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\PostCommentController;


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

//machi darori ndiro ndiro nfs nom n9dro nbdlo lvariable
//Route::get('/posts/{id}',function($myId){
//        return $myId;
//    });


    // double cout /post/id/author
   /* Route::get('/posts/{id}/{author}',function($myId,$author){
        return $myId ."author : $author";
    });*/

//
/*Route::get('/posts/{id}/{author?}',function($myId,$author='by default'){
    
    $posts=[
        1 => ['title' => 'learn laravel'],
        2 => ['title' => 'learn angular'],
    ];
    
    return view('posts.show',[
        'data' => $posts[$myId],
        'author' => $author
    ]);
});   */

    
    



Route::get('/', function () {
    return view('welcome');
});

//ila knti dir view statique matpasser liha hta information


//Route::get('/about', function () {
//    return view('about');
//});

Route::get('/hom', function () {
        return view('hom');
    });
    
Route::get('/home1','HomeController@home')->name('home1');
Route::get('/about','HomeController@about')->name('about');

//omly
Route::resource('/posts','PostController');//->only(['index','show','create','store','edit','update']);
     // mli kankhdmo ga3 les method sauf destroy->except(['destroy']);
     
//all methods
//Route::resource('/posts','PostController');

Route::get('/posts/archive',[PostController::class,'archive']);
Route::match(['get','patch'],'/posts/{id}/restore','PostController@restore');
Route::delete('/posts/{id}/forcedelete','PostController@forcedelete');

Route::get('/posts/all','PostController@all');
Route::get('/secret','HomeController@secret')
     ->name('secret')
     ->middleware('can:secret.page');

Route::get('/posts/tag/{id}',[PostTagController::class,'index'])->name('posts.tags');     

Route::resource('posts.comments','PostCommentController')->only(['store']);

Route::resource('users','UserController')->only(['show','edit','update']);
//Route::match(['post','get'],'posts/{post}/comments','PostCommentController@store')->name('posts.comments.store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
