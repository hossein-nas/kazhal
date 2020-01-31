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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    DB::delete('delete from oauth_access_tokens where user_id = ? and revoked = ?', [1, 1]);

    return $request->user();
});

Route::post('/login', 'Auth\LoginController@login');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/logout', 'Auth\LoginController@logout');
});
