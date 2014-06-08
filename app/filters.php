<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (!Auth::user()->check()) return Redirect::to(URL::to('/'));
});

//Add our console auth filter
Route::filter('consoleauth', function()
{
    if (!Auth::consoleuser()->check()) return Redirect::route('consolelogin')->with('requesturl', Request::path());
});
//Add our console auth elevated access level 1 filter
Route::filter('consoleauth1', function()
{
    if (!Auth::consoleuser()->check()) return Redirect::route('consolelogin')->with('requesturl', Request::path());

    if (!Auth::consoleuser()->get()->access >= 1) return Redirect::route('console');
});



Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
    //Possible places where are CSRF token is stored

    $post_token = Input::get('_token');
    $post_ajax = Input::get('data');
    //Let's first check for a regular token in our POST/GET data
    if (!empty($post_token)) {

        if (Session::token() != $post_token)
        {
            throw new Illuminate\Session\TokenMismatchException;
        }

    }
    //Darn that doesn't exist. That probably means this is an AJAX request. Let's check and see if we have a serialized string sent as data.
    elseif (!empty($post_ajax)) {
        //Parse the serialized string
        parse_str($post_ajax, $post);
        if (Session::token() != $post['_token'])
        {
            throw new Illuminate\Session\TokenMismatchException;
        }
    }

    //Now we are screwed, not even that. Let's get the hell out of here.
    else {
        throw new Illuminate\Session\TokenMismatchException;
    }
});