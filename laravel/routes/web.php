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

Route::get('/', function() {
    return view('top');
});
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');
Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
Route::resource('posts', 'PostsController', ['only' => ['index', 'show']]);

Route::group(['prefix' => 'users/{user}'], function() {    
    Route::get('followings', 'UsersController@followings')->name('users.followings');
    Route::get('followers', 'UsersController@followers')->name('users.followers');
});

Route::group(['prefix' => 'posts/{post}'], function() {
    Route::get('participateUsers', 'PostsController@participateUsers')->name('posts.participateUsers');
});

Route::group(['middleware' => 'auth'],function() {
    Route::resource('users', 'UsersController', ['only' => ['update', 'destroy', 'edit']]);
    Route::get('users/{user}/deleteWindow', 'UsersController@deleteWindow')->name('users.deleteWindow');
    Route::resource('posts', 'PostsController', ['only' => ['store', 'update', 'destroy', 'edit']]);
    Route::get('posts/{post}/deleteWindow', 'PostsController@deleteWindow')->name('posts.deleteWindow');
    Route::get('posts/{user}/create', 'PostsController@create')->name('posts.create');

    Route::group(['prefix' => 'users/{user}'], function() {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
    });

    Route::group(['prefix' => 'posts/{post}'], function() {
        Route::post('concern', 'ConcernsController@store')->name('concerns.concern');
        Route::delete('unconcern', 'ConcernsController@destroy')->name('concerns.unconcern');
        Route::post('participate', 'ParticipationsController@store')->name('participations.participate');
        Route::delete('cancel', 'ParticipationsController@destroy')->name('participations.cancel');
    });
});