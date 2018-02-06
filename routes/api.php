<?php

$app_domain = env('APP_DOMAIN','oauth.app');

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

Route::group([
    'domain'    =>  $app_domain,
    'namespace' =>  'Auth',
],function(){
    Route::post('login', 'LoginController@loginPass'); //用户登录
    Route::post('register', 'RegisterController@register'); //用户注册获取token
});



