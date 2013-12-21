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
Route::post('/ajax/registration', array('as' => 'ajaxRegistration', 'uses' => 'AjaxController@post_registration', 'before' => 'csrf'));
Route::post('/ajax/login', array('as' => 'ajaxLogin', 'uses' => 'AjaxController@post_login'));
Route::post('/ajax/logout', array('as' => 'ajaxLogout', 'uses' => 'AjaxController@post_logout', 'before' => 'auth'));
Route::get('/va', array('as' => 'va', 'uses' => 'VaController@get_va', 'before' => 'auth'));
Route::post('/ajax/vaedit', array('as' => 'ajaxVAEdit', 'uses' => 'AjaxController@post_vaedit', 'before' => 'auth|csrf'));