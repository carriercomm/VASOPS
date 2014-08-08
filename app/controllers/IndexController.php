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
    $publicCategories = Category::where('hidden', '!=', 1)->get();
    $categories = Category::all();
    //Figure out which categories have children
    $categoryChildren = array();
    foreach ($categories as $categoryParent) {
        if (Category::isParent($categoryParent->id)) {
            $categoryChildren[$categoryParent->id] = Category::getChildren($categoryParent->id);
        }
    }

    return View::make('index')->with(array('fname' => $fname, 'categories' => $categories, 'categoryChildren' => $categoryChildren, 'publicCategories' => $publicCategories));
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

    public function get_passwordreset($hash) {
        //Pull our user based on the hash
        $user = User::where('fptoken', '=', $hash)->first();
        if (empty($user)) {
            //Ouch, bad hash
            return Redirect::route('index')->with('topmessage', 'Sorry, that password reset link is either invalid or already used. Please request another link.');
        }
        else {
            //Ok, it is a good hash. Let's log the user in.
            Auth::user()->login($user);
            //Remove the hash from the database
            $user->fptoken = "";
            $user->save();
            $fname = User::getFirstName($user->cid);
            Session::put('fname', $fname);
            //Alright now we need to redirect them to their manager and advise them to change their password
            return Redirect::to('va#editva')->with('topmessage', 'The reset link was valid and you were logged in. Please change your password below.');
        }

    }

}