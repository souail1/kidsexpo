<?php

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('login', 'LoginController@index');
    Route::post('login', 'LoginController@signIn');
    Route::get('captcha/{rcode?}', 'LoginController@captcha');
    Route::get('logout', 'LoginController@logout');

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/', 'IndexController@index');
        Route::get('index', 'IndexController@index');
        Route::get('menu', 'IndexController@getMenu');
        Route::get('forbidden', 'IndexController@forbidden');
        Route::get('main', 'IndexController@main');
        Route::get('user/password/edit', 'IndexController@editPassword');
        Route::put('user/password', 'IndexController@editPassword');
        Route::resource('article', 'ArticleController');

        Route::get('articlesList', 'ArticleController@getArticle');
        Route::delete('article', 'ArticleController@destroy');


        Route::get('usersList', 'RuleController@adminsPage');
        Route::get('users', 'RuleController@getAdmins');
        Route::get('user/create', 'RuleController@addAdmin');
        Route::post('user', 'RuleController@addAdmin');
        Route::get('user/{id}/edit', 'RuleController@editAdmin');
        Route::put('user', 'RuleController@editAdmin');
        Route::patch('user', 'RuleController@activeAdmin');
        Route::delete('user', 'RuleController@delAdmin');
    });

});