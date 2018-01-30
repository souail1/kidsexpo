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
require 'admin.php';
Route::get('lang/{locale}', ['as'=>'lang.change', 'uses'=>'LanguageController@setLocale']);

Route::get('/', function () {
    return view('welcome');
});
Route::group(['namespace' => 'Index'], function () {
    Route::get('test', 'TestController@test');
    Route::post('test/post', 'TestController@testPost');
    Route::get('test/show', 'TestController@show');
    Route::get('test_job', 'TestController@testJob');
    Route::get('mail/send','MailController@send');
});
Route::get('mail/send','MailController@send');

// 认证路由...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
// 注册路由...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
