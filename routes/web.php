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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');

//注册
Route::get('/register','UsersController@create')->name('register');
//resource 方法来定义用户资源路由
Route::resource('/users','UsersController');

Route::get('login','SessionsController@create')->name('login');
Route::post('login','SessionsController@store')->name('login');
Route::delete('logout','SessionsController@destroy')->name('logout');

//用户激活路由 链接：http://www.laravel-web1.com/register/confirm/O1TTEr3faVq4fpzFXaOVQD4EAO9mQL
//问题：会发现，自动生成的字段 activation_token 是有可能重复的
Route::get('register/user/{id}/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');


//密码重设相关资源   laravel已经集成忘记密码和重置密码的相关控制器
Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset','Auth\ResetPasswordController@reset')->name('password.update');


//微博相关的操作路由 传参 only 键指定只生成某几个动作的路由
Route::resource('statuses','StatusesController',['only'=>['store','destroy']]);

//『关注的人』显示用户的关注人列表和『粉丝』显示用户的粉丝列表路由
Route::get('/users/{user}/followings','UsersController@followings')->name('users.followings');
Route::get('/users/{user}/followers','UsersController@followers')->name('users.followers');

//「关注用户」和「取消关注用户」路由
Route::post('/users/followers/{user}','FollowersController@store')->name('followers.store');
Route::delete('/users/followers/{user}','FollowersController@destroy')->name('followers.destroy');