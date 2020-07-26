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

Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'services'], function () {
    Route::get('{slug}/show/', 'Service\ServicesController@index');
});

Route::group(['prefix' => 'posts'], function () {
    Route::get('{slug}/show/', 'Post\PostsController@show');
});


Route::group(['prefix' => 'comment'], function () {
    Route::post('/add/', "CommentsController@create");
});


Route::post('/posts/create', 'Post\PostsController@store')->name('posts.store');
