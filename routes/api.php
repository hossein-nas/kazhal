<?php

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/logout', 'Auth\LoginController@logout');

    Route::post('/user/update', 'User\UsersController@update');
});

// Categories specific routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/category/all-cats', "CategoriesController@getAllCats");
    Route::post('/category/add-new', "CategoriesController@addNew");
});

// Posts pecific routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/posts/all-posts', "Post\PostsController@getAllPosts");
    Route::get('/posts/{id}', "Post\PostsController@getSinglePost");
    Route::post('/posts/add-new/post', "Post\PostsController@store")->name('posts.store');
    Route::delete('/posts/delete/{post}', "Post\PostsController@destroy")->name('posts.destroy');
});

// Files pecific routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/files/upload', "File\FilesController@store")->name('file-upload.store');
});

// Colors pecific routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/colors/all', 'ColorsController@index');
});

// Services pecific routes
Route::group(['middleware' => 'auth:api', 'prefix' => 'services'], function () {
    Route::post('/add-new/service', 'Service\ServicesController@addNew');
    Route::post('/get-all/services', 'Service\ServicesController@getAllServices');
    Route::post('/get-all/category/services', 'Service\ServicesController@getAllCategoryServices');
    Route::post('/get-service/{id}', 'Service\ServicesController@getSingleService');
    Route::post('/delete/service', 'Service\ServicesController@deleteService');
});

Route::get('/services/get-all/recursive/services', 'Service\ServicesController@getRecursiveServices');

Route::group(['middleware' => 'auth:api', 'prefix' => 'comments'], function () {
    Route::get('/', 'CommentsController@index')->name('comments.index');
    Route::post('/create/', 'CommentsController@store')->name('api.comment.store');
    Route::get('/{comment}/show', 'CommentsController@show')->name('comment.show');

    // approving
    Route::post('approve/{comment}/', 'Comments\ApproveCommentsController@index')->name('approve.comment');
    Route::post('bulk-approve', 'Comments\ApproveCommentsController@bulk')->name('bulk-approve.comment');
    Route::delete('approve/{comment}/', 'Comments\ApproveCommentsController@destroy')->name('unapprove.comment');

});
