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

Route::apiResource('/questions', 'QuestionController');

Route::apiResource('/categories', 'CategoryController');

Route::apiResource('/questions/{question}/replies', 'ReplyController');

Route::resource('/replies/{reply}/likes', 'LikeController')->only([
    'store', 'destroy'
]);

Route::delete('/replies/{reply}/likes', 'LikeController@destroy');

Route::get('/notifications', 'NotificationController@index');
Route::patch('/notifications', "NotificationController@update");

Route::patch('/profile', 'ProfileController@update');
Route::patch('/password', 'ChangePasswordController@update');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('/signup', 'AuthController@signup');
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/me', 'AuthController@me');
    Route::post('/payload', 'AuthController@payload');
    
});
