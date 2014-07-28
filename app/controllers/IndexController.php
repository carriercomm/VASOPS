<?php
class IndexController extends BaseController {

/**
* Make the index view
*/
public function get_index()
{
    $fname = "";
    if (Auth::check()) {
        $fname = User::getFirstName(Auth::user()->get()->cid);
    }

    //Pull category data
    $categories = Category::get();
    //Figure out which categories have children
    $categoryChildren = array();
    foreach ($categories as $categoryParent) {
        if (Category::isParent($categoryParent->id)) {
            $categoryChildren[$categoryParent->id] = Category::getChildren($categoryParent->id);
        }
    }

    return View::make('index')->with(array('fname' => $fname, 'categories' => $categories, 'categoryChildren' => $categoryChildren));
}

    public function get_tickethash($hash)
    {
        $ticket = Ticket::where('hash', '=', $hash)->first();
        if (empty($ticket))
            return Redirect::to('/#moduleSupport')->with('topmessage', 'Invalid Ticket Hash. Please enter your ticket ID and email below to locate the ticket.');
        $email = $ticket->email;
        $ticketid = $ticket->id;
        return Redirect::to('/#moduleSupport')->with(array('ticketemail' => $email, 'ticketid' => $ticketid));
    }

}