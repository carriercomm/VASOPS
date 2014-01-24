<?php
class ConsoleController extends BaseController {

    public function get_login()

    {
        return View::make('console.login');
    }
}