<?php

//upload
Route::post('upload', 'UploadController@upload');

Route::get('lang/{locale}', ['as'=>'lang.change', 'uses'=>'LanguageController@setLocale']);

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

        //article
        Route::get('articlesList', 'ArticleController@articlesPage');
        Route::get('articles', 'ArticleController@getArticles');
        Route::get('article/create', 'ArticleController@addArticle');
        Route::post('article', 'ArticleController@addArticle');
        Route::get('article/{id}/edit', 'ArticleController@editArticle');
        Route::put('article', 'ArticleController@editArticle');
        Route::patch('article', 'ArticleController@activeArticle');
        Route::delete('article', 'ArticleController@delArticle');
        Route::get('singlesList', 'ArticleController@singlesPage');
        Route::get('singles', 'ArticleController@getSingles');
        //banner
        Route::get('bannersList', 'BannerController@bannersPage');
        Route::get('banners', 'BannerController@getBanners');
        Route::get('banner/create', 'BannerController@addBanner');
        Route::post('banner', 'BannerController@addBanner');
        Route::get('banner/{id}/edit', 'BannerController@editBanner');
        Route::put('banner', 'BannerController@editBanner');
        Route::delete('banner', 'BannerController@delBanner');
        //cate
        Route::get('cates', 'CateController@Cates');
        Route::get('cate/create', 'CateController@addCate');
        Route::post('cate', 'CateController@addCate');
        Route::get('cate/{id}/edit', 'CateController@editCate');
        Route::put('cate', 'CateController@editCate');
        Route::delete('cate', 'CateController@deleteCate');
        Route::patch('cate', 'CateController@editCateStatus');



        Route::get('rules', 'RuleController@rules');
        Route::get('rule/create', 'RuleController@addRule');
        Route::post('rule', 'RuleController@addRule');
        Route::get('rule/{id}/edit', 'RuleController@editRule');
        Route::put('rule', 'RuleController@editRule');
        Route::delete('rule', 'RuleController@deleteRule');
        Route::patch('rule', 'RuleController@editRuleStatus');



    });

});