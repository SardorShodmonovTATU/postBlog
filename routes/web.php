<?php

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

Route::get('/','PostController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/post', 'PostController@post')->middleware('auth');
Route::get('/profile', 'ProfileController@profile')->middleware('auth');
Route::get('/category', 'CategoryController@category')->middleware('auth');
Route::post('/addCategory', 'CategoryController@addCategory')->middleware('auth');
Route::post('/addProfile', 'ProfileController@addProfile')->middleware('auth');
Route::post('/addPost', 'PostController@addPost')->middleware('auth');
Route::get('/view/{post}', 'PostController@show');
Route::get('/edit/{post}', 'PostController@edit')->middleware('auth');
Route::post('/editPost/{post}', 'PostController@editPost')->middleware('auth');
Route::get('/delete/{post}','PostController@deletePost')->middleware('auth');
Route::get('/category/{category}','PostController@category');
Route::get('/like/{id}', 'PostController@addLike')->middleware('auth');
Route::get('/dislike/{id}', 'PostController@disLike')->middleware('auth');
Route::post('/comment/{id}','PostController@comment')->middleware('auth');
Route::post('/searching', 'PostController@search')->name('search.input')->middleware('auth');
