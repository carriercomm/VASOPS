<?php
class IndexController extends BaseController {

/**
* Make the index view
*/
public function get_index()
{
    $fname = "";
    if (Auth::check()) {
        $fname = User::getFirstName(Auth::user()->cid);
    }
    return View::make('index')->with(array('fname' => $fname));
}

}