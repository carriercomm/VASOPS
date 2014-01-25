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

//Index - Root
Route::get('/', array('as' => 'index', 'uses' => 'IndexController@get_index'));

//AJAX
Route::post('/ajax/registration', array('as' => 'ajaxRegistration', 'uses' => 'AjaxController@post_registration', 'before' => 'csrf'));
Route::post('/ajax/login', array('as' => 'ajaxLogin', 'uses' => 'AjaxController@post_login'));
Route::post('/ajax/logout', array('as' => 'ajaxLogout', 'uses' => 'AjaxController@post_logout', 'before' => 'auth'));
Route::post('/ajax/vaedit', array('as' => 'ajaxVAEdit', 'uses' => 'AjaxController@post_vaedit', 'before' => 'auth|csrf'));
Route::post('/ajax/newticket', array('as' => 'ajaxNewTicket', 'uses' => 'AjaxController@post_newticket', 'before' =>'auth|csrf'));
Route::post('/ajax/closeticket', array('as' => 'ajaxCloseTicket', 'uses' => 'AjaxController@post_closeticket', 'before' =>'auth'));
Route::post('/ajax/reopenticket', array('as' => 'ajaxReopenTicket', 'uses' => 'AjaxController@post_reopenticket', 'before' =>'auth'));
Route::post('/ajax/replyticket', array('as' => 'ajaxReplyTicket', 'uses' => 'AjaxController@post_replyticket', 'before' =>'auth|csrf'));
Route::post('/ajax/checkimagelinkback', array('as' => 'ajaxCheckImageLinkBack', 'uses' => 'AjaxController@post_checkimagelinkback'));
Route::post('/ajax/getvasbycategory', array('as' => 'ajaxGetVasByCategory', 'uses' => 'AjaxController@post_getvasbycategory'));


//Pages
Route::get('/va', array('as' => 'va', 'uses' => 'VaController@get_va', 'before' => 'auth'));

//Console
Route::filter('authconsole', function ()
{
    //Change auth to use our ConsoleUser model not our VA model.

    //Check if this user is logged in as a VA account and if so log them out
//    if (!empty(Auth::user()->vaname)) {
//        Auth::logout();
//    }
//
//    Config::set('auth.model', 'ConsoleUser');

});
Route::when('console*', 'authconsole');

Route::get('/console', array('as' => 'console', 'uses' => 'ConsoleController@get_index', 'before' => 'consoleauth'));
Route::get('/console/login', array('as' => 'consolelogin', 'uses' => 'ConsoleController@get_login'));
Route::post('/console/login', array('as' => 'postconsolelogin', 'uses' => 'ConsoleController@post_login'));