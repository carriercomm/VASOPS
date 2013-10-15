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

//Get Index
Route::get('/', array('as' => 'index', 'uses' => 'IndexController@get_index'));

//Submit VA Registration
Route::post('/submitVARegistration', array('as' => 'submitVARegistration', 'uses' => 'IndexController@post_index'));