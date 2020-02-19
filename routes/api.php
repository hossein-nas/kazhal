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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     DB::delete('delete from oauth_access_tokens where user_id = ? and revoked = ?', [1, 1]);

//     return $request->user();
// });

Route::middleware('auth:api')->get('/user', 'User\UsersController@me');

Route::post('/login', 'Auth\LoginController@login');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/logout', 'Auth\LoginController@logout');

    Route::post('/user/update', 'User\UsersController@update');
});

// Categories specific routes
Route::group(['middleware' => 'auth:api'], function(){
	Route::get('/category/all-cats', "CategoriesController@getAllCats");
	Route::post('/category/add-new', "CategoriesController@addNew");
});

// Posts pecific routes
Route::group(['middleware' => 'auth:api'], function(){
	Route::get('/posts/all-posts', "Post\PostsController@getAllPosts");
	Route::get('/posts/{id}', "Post\PostsController@getSinglePost");
	Route::post('/posts/add-new/post', "Post\PostsController@add");
});

// Files pecific routes
Route::group(['middleware' => 'auth:api'], function(){
	Route::post('/files/upload', 'File\FilesController@index');
});

// Colors pecific routes
Route::group(['middleware' => 'auth:api'], function(){
	Route::get('/colors/all', 'ColorsController@index');
});

// Services pecific routes
Route::group(['middleware' => 'auth:api'], function(){
	Route::post('/services/add-new/service', 'Service\ServicesController@addNew');
	Route::post('/services/get-all/services', 'Service\ServicesController@getAllServices');
	Route::post('/services/get-all/category/services', 'Service\ServicesController@getAllCategoryServices');

	Route::post('/services/get-service/{id}', 'Service\ServicesController@getSingleService');
	Route::post('/services/delete/service', 'Service\ServicesController@deleteService');
});

	Route::get('/services/get-all/recursive/services', 'Service\ServicesController@getRecursiveServices');
