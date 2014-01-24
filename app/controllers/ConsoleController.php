<?php
class ConsoleController extends BaseController {

    function __construct()
    {
        Config::set('auth.model', 'ConsoleUser');
    }

    public function get_login()

    {
        return View::make('console.login');
    }
}