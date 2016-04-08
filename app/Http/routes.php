<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'index', 'uses' => 'WelcomeController@index']);
Route::get('contact', ['as' => 'contact', 'uses' => 'PagesController@contact']);
Route::get('about', ['as' => 'about', 'uses' => 'PagesController@about']);

Route::get('/', 'ArticlesController@index');

Route::resource('articles', 'ArticlesController');

Route::controller('hoge', 'HogeController');
