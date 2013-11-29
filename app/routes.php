<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'index', 'uses' => 'IndexController@get_index'));
Route::post('/ajax/registration', array('as' => 'ajaxRegistration', 'uses' => 'AjaxController@post_registration'));
Route::post('/ajax/login', array('as' => 'ajaxLogin', 'uses' => 'AjaxController@post_login'));
