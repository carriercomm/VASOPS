<?php

class ConsoleController extends BaseController {

    public function get_logout() {
        //Log the user out
        Auth::consoleuser()->logout();
        //Redirect to the login page with a message
        return Redirect::route('index')->with('topmessage', 'Logged out of the console successfully.');
    }

    public function get_login()

    {
//        *****SSO******
        $config = require app_path() . '/config/packages/vatsim/sso/config.php';
        $key = $config['key'];
        $base = $config['base'];
        $method = $config['method'];
        $secret = $config['secret'];
        $cert = $config['cert'];
        $return = $config['return'];
        return VatsimSSO::login(
            $return,
            function($key, $secret, $cert) {
                Session::put('vatsimauth', compact('key', 'secret'));
                return Redirect::to($cert);
            },
            function($error) {
                Redirect::route('index')->with('topmessage','Could not authenticate: ' . $error['message']);
            }
        );

//        return View::make('console.login');
    }

    public function post_validatelogin() {
        $session = Session::get('vatsimauth');

        return VatsimSSO::validate(
            $session['key'],
            $session['secret'],
            Input::get('oauth_verifier'),
            function($user, $request) {
                // At this point we can remove the session data.
                Session::forget('vatsimauth');
                //Verify that our user is a console user
                $find = ConsoleUser::where('cid', '=', $user->id)->where('access', '>', -1)->count();
                if ($find == 0)
                    return Redirect::route('index')->with('topmessage','Member not authorised to use VA Auditors Console');
                Auth::consoleuser()->loginUsingId($user->id);
                return Redirect::route('console');
            },
            function($error) {
                Redirect::route('index')->with('topmessage','Could not authenticate: ' . $error['message']);
            }
        );
    }

    public function post_login() {;
        $cid = Input::get('cid');
        $password = Input::get('password');

        $validator = Validator::make(
            array(
                'Cid' => $cid,
                'Password' => $password,
            ),
            array(
                'Cid' => 'required|integer',
                'Password' => '',
            ),
            array (
                'Cid.required' => 'Please enter your VATSIM CID.',
                'Cid.integer' => 'Invalid CID.',
                'Password.required' => 'You must enter a password.',
            )
        );

        if ($validator->fails())
        {
            // The given data did not pass validation
            $messages = $validator->messages();
            $errorStr = '';
            $count = count($messages);
            $i = 0;
            foreach ($messages->all(':message') as $message)
            {
                $i++;
                $errorStr .= '<span>' . $message . '</span>';
                if ($i != $count) {
                    $errorStr .= '<br /><hr />';
                }
            }
            return Redirect::route('consolelogin')->with('message', $errorStr)->with('cid', $cid);
        }
        else {

            $consoleuser = ConsoleUser::where('cid', '=', $cid)->where('access', '>', -1)->first();
            //If there is not a password set for the user then log them in and redirect them to their profile page to set a password
            if (empty($consoleuser->password) && $password == "initial") {
                Auth::consoleuser()->loginUsingId($cid);
                return Redirect::route('consoleprofile')->with('message', 'Verify your details and create a password for your account.');
            }
            if (!empty($consoleuser)) {
                //User with the provided CID exists. Now let's run the password
                if (Hash::check($password, $consoleuser->password)) {
                    //Credentials were valid. Let's login the user
                    Auth::consoleuser()->loginUsingId($cid);
                    //Check if there was a request url
                    $requesturl = Input::get('requesturl');
                    if (!empty($requesturl))
                        return Redirect::to($requesturl);
                    else
                        return Redirect::route('console');
                }
                else {
                    //Bad Password
                    return Redirect::route('consolelogin')->with('message', 'Invalid Password. ')->with('cid', $cid);
                }
            }
            else {
                //Bad CID
                return Redirect::route('consolelogin')->with('message', 'Invalid CID. ')->with('cid', $cid);

            }

        }

    }

    public function get_index() {

        //Determine and fetch unread helpdesk updates to be displayed in the dashboard.
        $cid = Auth::consoleuser()->get('cid');
        $unAssignedTickets = Ticket::where('status', '=', '1')->where('assigned', '=', '0')->get();
        //Fetch our two most recent audit logs
        $auditLogs = AuditLog::orderBy('created_at', 'DESC')->get();
        $i = 0;
        //Declare the two auditlog variables before in case laravel gets mad because they are not being called if there are no audit logs filed.
        $auditLog1 = '';
        $auditLog2 = '';
        foreach($auditLogs as $auditLog) {
            if ($i == 0)
                $auditLog1 = $auditLog;
            if ($i == 1)
                $auditLog2 = $auditLog;
            if ($i > 1)
                break;
            $i++;
        }
        $pendingVAs = User::where('status', '=', '0')->orderBy('awaiting_response', 'ASC')->orderBy('created_at', 'DESC')->get();
        $activeBroadcasts = Broadcast::where('status', '=', '1')->orderBy('created_at', 'DESC')->get();
        return View::make('console.index')->with(array('pendingVAs' => $pendingVAs, 'activeBroadcasts' => $activeBroadcasts, 'tickets' => $unAssignedTickets, 'auditLog1' => $auditLog1, 'auditLog2' => $auditLog2));
    }

    public function get_broadcasts() {
        $broadcasts = Broadcast::orderBy('status', 'DESC')->orderBy('created_at', 'DESC')->get();
        return View::make('console.broadcasts')->with(array('broadcasts' => $broadcasts));
    }

    public function post_broadcastsnew() {
        $content = Input::get('inputContent');
        $subject = Input::get('inputSubject');
        $broadcast = new Broadcast;
        $broadcast->content = $content;
        $broadcast->subject = $subject;
        //Todo finish this
        $broadcast->author = Auth::consoleuser()->get()->cid;
        //Make this broadcast active
        $broadcast->status = '1';
        $broadcast->save();

        return Redirect::route('consolebroadcasts')->with('message', 'New Broadcast Created Successfully.');
    }

    public function get_broadcastsremove($id) {
        Broadcast::destroy($id);
        return Redirect::route('consolebroadcasts')->with('message', 'Broadcast Removed Successfully.');
    }

    public function get_broadcastsvis($id) {
        $broadcast = Broadcast::find($id);
        if ($broadcast->status == 0) {
            $broadcast->status = 1;
        }
        else {
            $broadcast->status = 0;
        }
        $broadcast->save();
        return Redirect::route('consolebroadcasts')->with('message', 'Broadcast Visibility Successfully Updated');
    }

    public function post_ajaxsearch() {
        $data = Input::get('data');
        parse_str($data, $post);
        $query = $post['searchInput'];
        $like = '%' . $query . '%';

        if (is_Numeric($query)) {
            //Since it is numeric we are probably sorting by a CID. Let's try to find VAs by CID with this number
            $vas = User::where('cid', 'like', $like)->orderBy('cid', 'ASC')->get();
        }
        else {
            //Hmm maybe they are trying to find a VA by name or by the name of the owner or URL
            $vas = User::where('name', 'like', $like)->orWhere('url', 'like', $like)->orWhere('email', 'like', $like)->orWhere('vaname', 'like', $like)->orWhere('url', 'like', $like)->orderBy('vaname', 'ASC')->get();
        }

        if (count($vas) > 0) {
            //Format our output
            $send = '';
            foreach ($vas as $va) {
                $status = User::formatUserStatus($va->status);
                $send .= "<tr><td>$va->vaname</td><td>$status</td><td>$va->url</td><td>$va->cid</td><td>$va->name</td><td>$va->created_at</td><td><a class=\"searchEditVABtn\" href=\"" . URL::route('console') .  "/va/" . $va->cid . "\"><i class=\"fa fa-edit fa-fw\"</a></td></tr>";
            }
        }
        else {
            $send = '0';
        }
        echo $send;
    }

    public function get_va($id) {
        //Is someone trying to pass something other than an integer?
        if (!is_numeric($id)) {
            return Redirect::route('console');
        }
        $va = User::findOrFail($id);
        //Do we have a banner?
        //Ugh laravel gets mad when we don't so let's just set it as empty for now.
        $banner = '';
        if ($va->banner) {
            $banner = User::getBannerUrl($va->cid);
        }

        //Pull our banner directory from settings
        $banner_maxwidth = Setting::fetch('banner_maxwidth');
        $banner_maxheight = Setting::fetch('banner_maxheight');

        //Pull our audit log
        $audit_log = AuditLog::where('va', '=', $va->cid)->orderBy('created_at', 'DESC')->get();

        //Pull our tickets created by this VA
        $tickets = Ticket::where('vid', '=', $id)->orderBy('updated_at', 'DESC')->get();

        //Pull our hidden categories
        $hiddenCategories = Category::where('hidden', '=', 1)->get();
        //Create an array of hidden category ids
        $hiddenCategoryIds = array();
        foreach ($hiddenCategories as $hiddenCategory) {
            $hiddenCategoryIds[] = $hiddenCategory->id;
        }
        $categories = $va->categories;
        $categories = explode(',', $categories);
        //Get rid of the empty array pair
        array_pop($categories);
        $currentHiddenCategories = array();
        foreach ($categories as $category) {
            if (in_array($category, $hiddenCategoryIds))
                $currentHiddenCategories[] = $category;
        }
        //Pull our email templates
        $emailTemplates = EmailTemplate::where('author', '=', Auth::consoleuser()->get()->cid)->orderBy('name', 'DESC')->get();
        $sharedEmailTemplates = EmailTemplate::where('author', '!=', Auth::consoleuser()->get()->cid)->where('public', '=', '1')->orderBy('name', 'DESC')->get();
        return View::make('console.va')->with(array('va' => $va, 'banner' => $banner, 'audit_log' => $audit_log, 'banner_maxwidth' => $banner_maxwidth, 'banner_maxheight' => $banner_maxheight, 'tickets' => $tickets, 'emailTemplates' => $emailTemplates, 'sharedEmailTemplates' => $sharedEmailTemplates, 'hiddenCategories' => $hiddenCategories, 'currentHiddenCategories' => $currentHiddenCategories));
    }

    public function get_vaupdatestatus($id, $status) {
        //Verify the VA exists
        $va = User::findOrFail($id);
        //Verify the status is a valid number
        $possibleStatus = array('-1', '0', '1');
        if (in_array($status, $possibleStatus)) {
            //Update the VA
            $va->status = $status;
            $va->save();
            //Add an auditor note detailing this status change
            //and just for good measure...
            $statusname = AuditLog::getStatusName($status);
            AuditLog::createNotation($id, "VA status changed to <strong>" . $statusname . "</strong>");
            //If they are approving a VA then we need to send the VA approved email
            if ($status == 1) {
                //Great, now let's send our VA approved email to the member.
                $template = SystemEmailTemplate::find('va_approved');
                $subject = $template->subject;
                $email = $va->email;
                $content = EmailTemplate::replaceContent($template->content, $id);
                //Send our email
                $data = array('name' => $va->name, 'email' => $email, 'subject' => $subject);
                //Alright. Time to do some email sending.
                Mail::send('email.default', array("content" => $content), function($message) use ($data) {
                    $message->to($data['email'], $data['name'])->subject($data['subject']);
                });
                return Redirect::to('console/va/' . $id . '#status')->with('message', 'VA Approved and Email sent to VA informing them of their acceptance.');
            }
            //Finally redirect to the page
            return Redirect::to('console/va/' . $id . '#status');
        }
        else
            App::abort('404', 'Invalid Status');
    }

    public function get_vaupdatelinkbackstatus($id, $status) {
        //Verify the VA exists
        $va = User::findOrFail($id);
        //Verify the status is valid
        $possibleStatus = array('0', '1');
        if (in_array($status, $possibleStatus)) {
            //Update the linkback status
            $va->linkbackstatus = $status;
            //Save
            $va->save();
            //Finally redirect to the page
            return Redirect::to('console/va/' . $id . '#status');
        }
        else {
            App::abort('404', 'Invalid Linkback Status');
        }
    }

    public function get_helpdesk($filter) {
        $filter = strtolower($filter);
        //Make sure our filter is valid
        if ($filter != "open" && $filter != "closed" && $filter != "assigned")  {
            //Shit, that's bad. Throw a 404.
            App::abort(404, 'Invalid helpdesk filter');
        }

        //Create our subheader based on the URL parameter and fetch the relevant list of tickets
        switch($filter){
            case 'open':
                $subheader = "Open Tickets";
                $tickets = Ticket::where('status', '=', '1')->get();
                break;
            case 'closed':
                $subheader = "Closed Tickets";
                $tickets = Ticket::where('status', '=', '0')->get();
                break;
            case 'assigned':
                $subheader = "Assigned Tickets";
                $tickets = Ticket::where('assigned', '=', Auth::consoleuser()->get()->cid)->where('status', '=', '1')->get();
                break;
        }
        //Get the replies
        $repliescount = array();
        foreach ($tickets as $ticket) {
            $repliescount[$ticket->id] = Ticket::find($ticket->id)->replies()->count();
        }
        return View::make('console.helpdesk')->with(array('subheader' => $subheader, 'tickets' => $tickets, 'repliescount' => $repliescount));

    }

    public function get_helpdeskview($id) {
        //Find the ticket or fail
        $ticket = Ticket::findOrFail($id);
        //Find the replies
        $replies = Ticket::find($id)->replies;
        //Get a list of auditors (who still have access and not ourselves), for our assign ticket select
        $auditors = ConsoleUser::where('access', '>', '-1')->where('cid', '!=', Auth::consoleuser()->get()->cid)->orderBy('name', 'ASC')->get();
        //Make the view
        return View::make('console.helpdeskview')->with(array('ticket' => $ticket, 'replies' => $replies, 'auditors' => $auditors));
    }

    public function post_helpdeskreply($id) {
        //Find the ticket to reply to or fail
        $ticket = Ticket::findOrFail($id);
        //Update the timestamps for the ticket
        $ticket->touch();
        //We have client side verification here so if they modified the JS and submitted an empty reply screw them and just abort.
        $content = Input::get('inputReplyContent');
        if (empty($content))
            App::abort('404', 'Page not found. Reply content not sent.');
        //Create a new instance of TicketReply
        $reply = new TicketReply();
        $reply->tid = $id;
        $reply->author = Auth::consoleuser()->get()->cid;
        $reply->staff = 1;
        $reply->content = $content;
        $reply->save();
        //Figure out what button was clicked, be it reply, reply and open, or reply and close
        if (Input::get('replyAndOpenSubmit')) {
            $ticket->status = 1;
            $ticket->save();
            //Declare the success message
            $message = "Your ticket reply was successfully submitted and the ticket was reopened.";
        }
        else if (Input::get('replyAndCloseSubmit')) {
            $ticket->status = 0;
            $ticket->save();
            //Declare the success message
            $message = "Your ticket reply was successfully submitted and the ticket was closed.";
        }
        else {
            //Declare the success message
            $message = "Your ticket reply was successfully submitted.";
        }
        //Email the VA advising them that there is a new response
        if ($ticket->vid == -1) {
            $data = array();
            $data['subject'] = "VATSIM VA New Ticket Update";
            $data['email'] = $ticket->email;
            $data['name'] = $ticket->name;
            if (!empty($data['email'])) {
                $body = "Hello " . $data['name'] . ",<br /><br />There has been an update to your " . $ticket->subject . " ticket by Auditor " . ConsoleUser::getName(Auth::consoleuser()->get()->cid) . ". <br /><br />" . $content . "<br /><br /><br /> <strong>Do not reply to this email. If you wish to reply to this ticket, please do so through your account online.</strong>";
                Mail::send('email.default', array("content" => $body), function($message) use ($data) {
                    $message->to($data['email'], $data['name'])->subject($data['subject']);
                });
            }
        }
        else {
            $va = User::where('cid', '=', $ticket->vid)->first();
            $data = array();
            $data['va'] = $va;
            $data['subject'] = "VATSIM VA New Ticket Update";
            if (!empty($va->email)) {
                $body = "Hello " . User::getFirstName($ticket->vid) . ",<br /><br />There has been an update to your " . $ticket->subject . " ticket by Auditor " . ConsoleUser::getName(Auth::consoleuser()->get()->cid) . ". <br /><br />" . $content . "<br /><br /><br /> <strong>Do not reply to this email. If you wish to reply to this ticket, please do so through your account online.</strong>";
                Mail::send('email.default', array("content" => $body), function($message) use ($data) {
                    $message->to($data['va']->email, $data['va']->name)->subject($data['subject']);
                });
            }
        }
        //All set now just redirect back to the ticket page with the message
        return Redirect::to('console/helpdesk/view/' . $id)->with(array('scrollTo' => '#ticketReply' . $reply->id, 'message' => $message));
    }

    public function get_helpdeskclose($id) {
        //Verify this is a valid ticket id
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 0;
        $ticket->save();
        //That was easy. Now just redirect back
        return Redirect::to('console/helpdesk/view/' . $id)->with('message', 'Ticket status successfully changed to closed.');
    }

    public function get_helpdeskopen($id) {
        //Verify this is a valid ticket id
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 1;
        $ticket->save();
        //That was easy. Now just redirect back
        return Redirect::to('console/helpdesk/view/' . $id)->with('message', 'Ticket status successfully changed to open.');
    }

    public function get_post_helpdeskassign($id, $cid=""){
        //Verify the ticket exists
        $ticket = Ticket::findOrFail($id);
        //Check to see if the CID is passed via the URL or if it is sent in the post form data
        if (!empty($cid)) {
            //Verify the console user exists
            $user = ConsoleUser::findOrFail($cid);
        }
        else {
            $cid = Input::get('assignToTicketSelect');
            $user = ConsoleUser::where('cid', '=', $cid)->where('access', '>', '-1')->count();
            if ($user == 0)
                App::abort('404', 'Console User model not found');
        }
        //Update the ticket
        $ticket->assigned = $cid;
        $ticket->save();
        //That was easy. Now just redirect back
        return Redirect::to('console/helpdesk/view/' . $id)->with('message', 'Ticket successfully assigned to ' . ConsoleUser::getName($cid));
    }

    public function get_helpdeskdelete($id) {
        //Verify the ticket exists
        $ticket = Ticket::findOrFail($id);
        //Now delete the replies to start
        Ticket::find($id)->replies()->delete();
        //And finally the ticket
        $ticket->delete();
        //That was easy. Now just redirect back to the dashboard with a message
        return Redirect::route('console')->with('message', 'Ticket successfully deleted.');
    }

    public function get_emailtemplates() {
        $myTemplates = EmailTemplate::where('author', '=', Auth::consoleuser()->get()->cid)->orderBy('name', 'ASC')->get();
        $sharedTemplates = EmailTemplate::sharedTemplates();
        if (Auth::consoleuser()->get()->access > 0) {
            $systemTemplates = SystemEmailTemplate::orderBy('id', 'ASC')->get();
            return View::make('console.emailtemplates')->with(array('myTemplates' => $myTemplates, 'sharedTemplates' => $sharedTemplates, 'systemTemplates' => $systemTemplates));
        }
        return View::make('console.emailtemplates')->with(array('myTemplates' => $myTemplates, 'sharedTemplates' => $sharedTemplates));
    }

    public function post_emailtemplatenew() {
        //Get our input fields
        $name = Input::get('inputName');
        $subject = Input::get('inputSubject');
        $content = Input::get('inputContent');
        $public = Input::get('inputPublic');
        //No need to run the validator for this. Let's just check and see if the fields are empty.
        if (empty($name))
            return Redirect::route('consoleemailtemplates')->with(array('error' => 'Please enter a template name.', 'inputContent' => $content, 'inputSubject' => $subject));
        if (empty($subject))
            return Redirect::route('consoleemailtemplates')->with(array('error' => 'Please enter a subject.', 'inputContent' => $content, 'inputName' => $name));
        if (empty($content))
            return Redirect::route('consoleemailtemplates')->with(array('error' => 'Please compose a body.', 'inputSubject' => $subject, 'inputName' => $name));
        //Create the record in the database
        if ($public != 1)
            $public = 0;
        $template = new EmailTemplate();
        $template->name = $name;
        $template->author = Auth::consoleuser()->get()->cid;
        $template->subject = $subject;
        $template->content = $content;
        $template->public = $public;
        $template->save();
        return Redirect::route('consoleemailtemplates')->with('message', 'New Template Created Successfully.');
    }

    public function get_emailtemplateedit($id) {
        //Verify we are editing our own template (unless we our access level is > 0)
        if (Auth::consoleuser()->get()->access < 1) {
            $check = EmailTemplate::where('id', '=', $id)->where('author', '=', Auth::consoleuser()->get()->cid)->count();
            if ($check < 1) {
                return Redirect::route('consoleemailtemplates')->with('error', 'Unauthorized template edit');
            }
        }
        //All clear let's query the db and return the view
        $template = EmailTemplate::findOrFail($id);
        return View::make('console.emailtemplateedit')->with(array('template' => $template));
    }

    public function post_emailtemplateedit($id) {
        //Verify we are editing our own template (unless we our access level is > 0)
        if (Auth::consoleuser()->get()->access < 1) {
            $check = EmailTemplate::where('id', '=', $id)->where('author', '=', Auth::consoleuser()->get()->cid)->count();
            if ($check < 1) {
                return Redirect::route('consoleemailtemplates')->with('error', 'Unauthorized template edit');
            }
        }
        //Pull our fields
        $name = Input::get('inputName');
        $subject = Input::get('inputSubject');
        $content = Input::get('inputContent');
        $public = Input::get('inputPublic');

        if (empty($name) || empty($subject) || empty($content))
            return Redirect::to('console/emailtemplates/edit/' . $id)->with('error', 'Please complete all of the required fields.');

        if ($public != 1)
            $public = 0;
        //All clear let's update the db
        $template = EmailTemplate::findOrFail($id);
        $template->name = $name;
        $template->subject = $subject;
        $template->content = $content;
        $template->public = $public;
        $template->save();
        return Redirect::route('consoleemailtemplates')->with('message', 'Template Updated.');
    }

    public function post_emailtemplatedelete() {
        //Get our id
        $id = Input::get('id');
        //Verify that the id is valid and the template is owned by the member trying to delete it or they are level 1 access
        if (Auth::consoleuser()->get()->access > 0)
            $query = EmailTemplate::where('id', '=', $id)->count();
        else
            $query = EmailTemplate::where('id', '=', $id)->where('author', '=', Auth::consoleuser()->get()->cid)->count();
        if ($query > 0) {
            //Count is greater than 0 let's delete the record;
            EmailTemplate::where('id', '=', $id)->delete();
        }
    }

    public function post_vaedit() {
        //Declare our variables
        $va = Input::get('va');
        $field = Input::get('field');
        $value = Input::get('value');
        //Create an array of the displayed names with the current database columns to match
        $fieldarray = array();
        $fieldarray['cid'] = 'cid';
        $fieldarray['name'] = 'name';
        $fieldarray['email'] = 'email';
        $fieldarray['url'] = 'url';
        $fieldarray['linkback url'] = 'vatsimimagepagelink';
        $fieldarray['city'] = 'city';
        $fieldarray['state'] = 'stateprovince';
        $fieldarray['postal'] = 'zip';
        $fieldarray['country'] = 'country';
        $fieldarray['description'] = 'description';

        if (!array_key_exists($field, $fieldarray)) {
            //Return 0 to the client
            echo '0';
        }
        else {
            $field = $fieldarray[$field];
            //fetch our va
            $va = User::findOrFail($va);
            //update the property
            $va->$field = $value;
            //push to the db
            $va->save();
            //Return 1 to the client;
            echo '1';
        }
    }

    public function post_createauditlog() {
        //Get our data
        $va = Input::get('va');
        $content = Input::get('content');
        $content = nl2br($content);
        //Ensure that some idiot didn't try to remove the clientside verification and the content is not in fact empty
        if (!empty($content)) {
            //Ensure some idiot didn't try to change the va to some nonexistent VA
            User::findOrFail($va);
            //Create our notation
            AuditLog::createNotation($va, $content);
            //Return one to the client
            echo 1;
        }
    }

    public function post_uploadbanner() {
        //Verify we have a file
        if (Input::hasFile('inputBanner')) {
            //Pull our VA CID from the hidden input
            $va = Input::get('va');
            $cid = $va;
            //Ensure this is a valid VA or fail with a model not found
            User::findOrFail($va);
            //Get our file
            $banner = Input::file('inputBanner');
            //Create an array of acceptable mimetypes
            $mimetypes = array('image/jpeg', 'image/png');
            if (in_array($banner->getMimeType(), $mimetypes)) {
                switch ($banner->getMimeType()) {
                    case('image/jpeg'):
                        $extension = ".jpg";
                        break;
                    case('image/png'):
                        $extension = ".png";
                        break;
                }
                //Get our image height min and max
                $maxheight = Setting::fetch('banner_maxheight');
                $maxwidth = Setting::fetch('banner_maxwidth');
                list($width, $height) = getimagesize($banner);
                //Is the width or height larger than the max?
                if ($width > $maxwidth || $height > $maxheight) {
                    App::abort(400, 'Image is larger than the max width: ' . $maxwidth . 'px or max height: ' . $maxheight . 'px');
                }
                //Mime check passed continue to move the image from tmp directory to /banners
                $destinationPath = public_path() . Setting::fetch('banner_directory');
                $fileName = $va . $extension;
                $banner->move($destinationPath, $fileName);
                //Finally update the db with the new banner name.
                $va = User::where('cid', '=', $va)->first();
                $va->banner = $fileName;
                $va->save();
                //Redirect the user back to the VA Profile
                return Redirect::to('console/va/' . $cid . '#banner')->with('message', 'Banner Uploaded Successfully.');
            }
        }
    }

    public function post_removebanner() {
        //Get our VA
        $cid = Input::get('va');
        //Ensure this is a valid VA or fail with a model not found
        $va = User::findOrFail($cid);
        if (!$va->banner) {
            App::abort('404');
        }
        $public_path = public_path();
        $banner_directory = Setting::fetch('banner_directory');
        $path = $public_path . $banner_directory . '/' . $va->banner;
        //Delete the image
        unlink($path);
        //Update the database
        $va->banner = '';
        $va->save();
        return Redirect::to('console/va/' . $cid . '#banner')->with('message', 'Banner Removed Successfully.');
    }

    public function post_findlinkback() {
        $va = Input::get('va');
        $response = User::testLinkBack($va);
        //This will return a boolean either true or false based on if the link is found using cURL
        if ($response) {
            $response = 1;
        }
        else {
            $response = 0;
        }
        return $response;
    }

    public function get_categories() {
        //Potential parents are nonchild categories.
        $potentialparents = Category::where('parentid', '=', '')->get();
        $children = Category::where('parentid', '!=', '')->get();
        $parentsarray = Array();
        foreach ($children as $child) {
            if (!in_array($child->parentid, $parentsarray))
                //If the parent is not already in the array add it.
                $parentsarray[$child->id] = $child->parentid;
        }
        return View::make('console.categories')->with(array('potentialparents' => $potentialparents, 'children' => $children, 'parentsarray' => $parentsarray));
    }

    public function post_categoriesnew() {
        $name = Input::get('inputCategoryName');
        //There is front end validation that name is not empty, but let's make sure someone isn't screwing with us.
        if (empty($name)) {
            return Redirect::route('consolecategories')->with('message', 'Please enter a category name');
        }
        $parent = Input::get('inputCategoryParent');
        if (!empty($parent)) {
            //Fetch a list of potential parents in order to verify this input
            $potentialparents = Category::where('parentid', '=', '');
            $parents = array();
            foreach($potentialparents as $potentialparent) {
                $parents[$potentialparent->id] = $potentialparent->name;
            }
            //Check the array keys
            if (!array_key_exists($parent, $parents))
                Redirect::route('consolecategories')->with('message', 'Invalid Parent.');

        }
        //Good our validation is done let's create the new category
        $category = new Category;
        $category->name = $name;
        if (!empty($parent))
            $category->parentid = $parent;
        //Save our data
        $category->save();
        return Redirect::route('consolecategories')->with('message', 'New Category Created Successfully');;
    }

    public function post_categoriesdeletechild() {
        $i = 0;
        $id = Input::get('id');
        //Verify this is a valid ID and is in fact a child
        $category = Category::where('id', '=', $id)->firstOrFail();
        if (!empty($category->parentid)) {
            $category->delete();
            //Now to remove all of the VAs that currently have that category selected
            $vas = User::where('categories', 'like', '%' . $id . ',%')->get();
            if (!empty($vas)) {
                //Another check to verify we have the correct VAs then let's update the categories without the removed category
                foreach ($vas as $va) {
                    $categoryarray = explode(',', $va->categories);
                    $key = array_search($id, $categoryarray);
                    if ($key) {
                        //Remove the array key/value pair.
                        unset($categoryarray[$key]);
                        //Convert the array back into a comma delimited list
                        $i = 0;
                        foreach ($categoryarray as $vacategory) {
                            //Continue if we just reach a category with a value of ,
                            if ($i > 0)
                                $categorylist .= $vacategory . ',';
                            else
                                $categorylist = $vacategory . ',';
                            $i++;
                        }
                        //Make sure our string doesn't have two commas at the end
                        $categorylist = rtrim($categorylist, ',,');
                        //Add back the one comma at the end if removed
                        if (substr($categorylist, '-1') != ',')
                            $categorylist = $categorylist . ',';
                        //Finally update the va record
                        $va->categories = $categorylist;
                        $va->save();
                    }
                }
            }
        }

        echo $i;
    }

    public function post_categoriesdeleteparent() {
        $id = Input::get('id');
        $hasChildren = Input::get('hasChildren');
        //Sanitize our id (ensure a category exists with this id
        $check = Category::findOrFail($id);
        $vas = User::where('categories', 'like', '%' . $id . ',%')->get();
        if (!empty($vas)) {
            //Another check to verify we have the correct VAs then let's update the categories without the removed category
            foreach ($vas as $va) {
                $categoryarray = explode(',', $va->categories);
                $key = array_search($id, $categoryarray);
                if ($key) {
                    //Remove the array key/value pair.
                    unset($categoryarray[$key]);
                    //Convert the array back into a comma delimited list
                    $i = 0;
                    foreach ($categoryarray as $vacategory) {
                        //Continue if we just reach a category with a value of ,
                        if ($i > 0)
                            $categorylist .= $vacategory . ',';
                        else
                            $categorylist = $vacategory . ',';
                        $i++;
                    }
                    //Make sure our string doesn't have two commas at the end
                    $categorylist = rtrim($categorylist, ',,');
                    //Add back the one comma at the end if removed
                    if (substr($categorylist, '-1') != ',')
                        $categorylist = $categorylist . ',';
                    //Finally update the va record
                    $va->categories = $categorylist;
                    $va->save();
                }
            }
            //If we don't have any children then we won't be executing the next code block and we need to return 0 children to the client
            if (!$hasChildren)
                echo 0;
        }
        //Let's figure out if we are working with any children here
        if ($hasChildren) {
            //Now to do the same with the children categories. It would be a really complex query to get only VAs with any of the child categories in the categories list so we will just sort through them all
            //Get a list of children categories
            $childrenquery = Category::where('parentid', '=', $id)->get();
            $children = array();
            foreach ($childrenquery as $child) {
                $children[] = $child->id;
            }
            $childrencount = count($children);
            $vas = User::get();
            if (!empty($vas)) {
                foreach ($vas as $va) {
                    $categoryarray = explode(',', $va->categories);
                    //For each child category id we will need to check this. Painful as hell, yeah I know
                    foreach($children as $child) {
                        $key = array_search($child, $categoryarray);
                        if ($key) {
                            //Remove the array key/value pair.
                            unset($categoryarray[$key]);
                            //Convert the array back into a comma delimited list
                            $i = 0;
                            foreach ($categoryarray as $vacategory) {
                                //Continue if we just reach a category with a value of ,
                                if ($i > 0)
                                    $categorylist .= $vacategory . ',';
                                else
                                    $categorylist = $vacategory . ',';
                                $i++;
                            }
                            //Make sure our string doesn't have two commas at the end
                            $categorylist = rtrim($categorylist, ',,');
                            //Add back the one comma at the end if removed
                            if (substr($categorylist, '-1') != ',')
                                $categorylist = $categorylist . ',';
                            //Finally update the va record
                            $va->categories = $categorylist;
                            $va->save();
                        }
                    }
                }
            }
            //Delete our parent category and the children. Let's start with the children first.
            $query = Category::where('parentid', '=', $id)->delete();
            //Finally delete our parent
            echo $childrencount;
        }
        $query2 = Category::where('id', '=', $id)->delete();
        //Hopefully all went well.

    }

    public function get_categoriesedit($id) {
        if (empty($id) || is_int($id)) {
            //Oops, no id...
            App:abort(404, 'Category ID parameter not found');
        }
        //Pull the category
        $category = Category::findOrFail($id);
        //Get a list of potential parents (excluding this category of course)
        $potentialParents = Category::where('parentid', '=', '')->where('id', '!=', $id)->get();
        return View::make('console.categoriesedit')->with(array('category' => $category, 'potentialParents' => $potentialParents));
    }

    public function post_categoriesedit($id) {
        //Get our fields
        $name = Input::get('categoryName');
        $parent = Input::get('categoryParent');

        $validator = Validator::make(
            array(
                'id' => $id,
                'name' => $name,
                'parent' => $parent,
            ),
            array(
                'id' => 'required|integer',
                'name' => 'required',
                'parent' => 'integer'
            ),
            array (
                'id.required' => 'The category ID was not included with the request. This is an internal error. ',
                'id.integer' => 'Invalid category ID format. This is an internal error.',
                'name.required' => 'You forgot to enter a name. Please enter a name and try again.',
            )
        );

        if ($validator->fails())
        {
            // The given data did not pass validation
            $messages = $validator->messages();
            $errorStr = '';
            $count = count($messages);
            $i = 0;
            foreach ($messages->all(':message') as $message)
            {
                $i++;
                $errorStr .= '<span>' . $message . '</span>';
                if ($i != $count) {
                    $errorStr .= '<br /><hr />';
                }
            }
            return Redirect::to('console/categories/edit/' . $id)->with('message', $errorStr);

        }
        //Great all of our validation is done. Hey, not so fast. Let's make sure that we are in fact modifying a valid category and the parent exists
        //Pull the category
        $category = Category::findOrFail($id);
        if ($parent != 0)
            $check = Category::where('id', '=', $parent)->where('parentid', '=', '0')->firstOrFail();
        $category->name = $name;
        $category->parentid = $parent;
        if (Input::get('categoryHidden') == 1)
            $category->hidden = 1;
        else
            $category->hidden = 0;
        $category->save();
        //Great, all done. Now to redirect the user.
        return Redirect::route('consolecategories')->with('message', 'Category successfully updated.');
    }

    public function get_auditmanagers() {
        //Get a list of audit managers that are currently active
        $auditors = ConsoleUser::where('access', '>=', '0')->get();
        $inactiveAuditors = ConsoleUser::where('access', '=', '-1')->get();
        //Return our view
        return View::make('console.auditmanagers')->with(array('auditors' => $auditors, 'inactiveAuditors' => $inactiveAuditors));
    }

    public function post_auditmanagersadd() {
        //Get our values
        $cid = Input::get('inputCid');
        $name = Input::get('inputName');
        $access = Input::get('inputAccess');
        //Create our validator
        $validator = Validator::make(array(
            'cid' => $cid,
            'name' => $name,
            'access' => $access,
        ),
        array(
            'cid' => 'integer|required|unique:consoleusers',
            'name' => 'required',
            'access' => 'integer|in:0,1'
        ));
        if ($validator->fails()) {
            return Redirect::route('consoleauditmanagers')->withErrors($validator);
        }

        //Great validation passed now just to insert our new data
        $consoleuser = new ConsoleUser();
        $consoleuser->cid = $cid;
        $consoleuser->name = $name;
        $consoleuser->access = $access;
        $consoleuser->save();
        //All done. Now redirect back
        return Redirect::route('consoleauditmanagers')->with('message', 'Audit Manager <strong>' . $name . '</strong> added successfully.');
    }

    public function post_auditmanageredit() {
        $remove = Input::get('editAuditManagerInputRemove');
        $cid = Input::get('cid');
        if (empty($remove)) {
            //Get our values
            $name = Input::get('editAuditManagerInputName');
            $access = Input::get('editAuditManagerInputAccess');
            //Create our validator
            $validator = Validator::make(array(
                    'cid' => $cid,
                    'name' => $name,
                    'access' => $access,
                ),
                array(
                    'cid' => 'required|exists:consoleusers,cid',
                    'name' => 'required',
                    'access' => 'integer|in:0,1'
                ));
            if ($validator->fails()) {
                return Redirect::route('consoleauditmanagers')->withErrors($validator);
            }

            //Great validation passed now just to insert our new data
            $consoleuser = ConsoleUser::findOrFail($cid);
            $consoleuser->name = $name;
            $consoleuser->access = $access;
            $consoleuser->save();
            //All done. Now redirect back
            return Redirect::route('consoleauditmanagers')->with('message', 'Audit Manager <strong>' . $name . '</strong> edited successfully.');
        }
        else {
            //OK we are removing this guy (in other words setting his access to -1
            $consoleuser = ConsoleUser::findOrFail($cid);
            $consoleuser->access = "-1";
            $consoleuser->save();
            //No redirect back
            return Redirect::route('consoleauditmanagers')->with('message', 'Audit Manager <strong>' . $consoleuser->name . '</strong> removed successfully.');
        }
    }

    public function get_auditmanagerrestore($id) {
        //Verify the ID exists
        $consoleuser = ConsoleUser::findOrFail($id);
        //Update his access to 0 (Audit Manager)
        $consoleuser->access = 0;
        $consoleuser->save();
        //Redirect back
        return Redirect::route('consoleauditmanagers')->with('message', 'Audit Manager <strong>' . $consoleuser->name . '</strong> access restored successfully.');
    }

    public function get_assignauditors() {
        //Pull our categories
        //Potential parents are nonchild categories.
        $potentialparents = Category::where('parentid', '=', '')->get();
        $children = Category::where('parentid', '!=', '')->get();
        $parentsarray = Array();
        foreach ($children as $child) {
            if (!in_array($child->parentid, $parentsarray))
                //If the parent is not already in the array add it.
                $parentsarray[$child->id] = $child->parentid;
        }
        //Get all of our parents and find the amount of VAs associated with each
        $categories = Category::all();
        $vaInCategories = array();
        foreach ($categories as $category) {
            $vaInCategories[$category->id] = User::where('categories', 'like', '%' . $category->id . ',%')->count();
        }
        //Fetch a list of active auditors
        $auditors = ConsoleUser::where('access', '>', '-1')->get();
        //Calculate how many assignments each auditor currently has
        $assignmentsPerAuditor = array();
        foreach ($auditors as $auditor) {
            $assignments = Assignment::where('auditors', 'like', '%' . $auditor->cid . ',%')->get();
            $assignmentsPerAuditor[$auditor->cid] = 0;
            foreach ($assignments as $assignment) {
                $vas = explode(',', $assignment->vas);
                $vascount = count($vas) - 1;
                //Remove the last value of the array (if it is empty)
                if (empty($vas[$vascount]))
                    unset($vas[$vascount]);
                $count = count($vas);
                $assignmentsPerAuditor[$auditor->cid] += $count;
            }
        }
        return View::make('console.assignauditors')->with(array('potentialparents' => $potentialparents, 'children' => $children, 'parentsarray' => $parentsarray, 'vaInCategories' => $vaInCategories, 'auditors' => $auditors, 'assignmentsPerAuditor' => $assignmentsPerAuditor));
    }

    public function post_assignauditors() {
        $auditors = Input::get('auditorCheckBox');
        $categories = Input::get('categoryCheckBox');
        //Start our validator
        $validator = Validator::make(array(
            'auditors' => $auditors,
            'categories' => $categories,
        ), array(
            'auditors' => 'required|array',
            'categories' => 'required|array',
        ));
        if ($validator->fails()) {
            return Redirect::route('consoleassignauditors')->withErrors($validator);
        }
        $auditors = implode(',', $auditors) . ',';
        $vas = '';
        foreach ($categories as $category) {
            $query = User::where('categories', 'like', '%' . $category . ',%')->get();
            foreach ($query as $va) {
                $vas = $vas . $va->cid . ',';
            }
        }
        //Now check for duplicate entries (duplicate VAs)
        $vaarray = explode(',', $vas);
        //Remove the last empty array key
        $vaarraycount = count($vaarray) - 1;
        unset($vaarray[$vaarraycount]);
        //Remove duplicate keys
        $vaarray = array_unique($vaarray);
        //Convert it back to a comma delimitted string
        $vas = implode(',', $vaarray) . ',';
        $categories = implode(',', $categories) . ',';
        $assignment = new Assignment();
        $assignment->vas = $vas;
        $assignment->categories = $categories;
        $assignment->auditors = $auditors;
        //Save our new assignment
        $assignment->save();
        //Finally redirect back to the assignments page
        return Redirect::route('consoleassignauditors')->with('message', 'New Auditor Assignment Created Successfully.');
    }

    public function get_assignments() {
        //Just declare this here since laravel get's mad if it is empty
        $othersassignments = '';
        //Pull our assignments for the current user
        $assignments = Assignment::where('auditors', 'like', '%' . Auth::consoleuser()->get()->cid . ',%')->get();
        //Create an array of each VA that needs to be auditted
        $vaslist = array();
        foreach ($assignments as $assignment) {
            $vas = $assignment->vas;
            $vas = explode(',', $vas);
            //Remove the last empty valuee

            $vascount = count($vas) - 1;
            unset($vas[$vascount]);
            foreach ($vas as $va) {
                $result = User::findOrFail($va);
                $vaslist[] = array('cid' => $va, 'vaname' => $result->vaname, 'assignmentid' => $assignment->id);
            }
        }
        //Is our user an administrator?
        if (Auth::consoleuser()->get()->access > 0) {
            //Yes, ok let's query for all of the assignments other than their own
            $othersassignments = Assignment::where('auditors', 'not like', '%' . Auth::consoleuser()->get()->cid . ',%')->get();
        }
        //Pull a list of all of the categories
        $categories = Category::all();
        //Create an array of categories with the key as the cat id and the value the name
        $catnames = array();
        foreach ($categories as $category) {
            $catnames[$category->id] = $category->name;
        }
        //Pull all assignments
        $allassignments = Assignment::all();
        $categoriesPerAssignment = array();
        $auditorsPerAssignment = array();
        foreach ($allassignments as $allassignment) {
            //Create a list of other auditors per assignment
            $auditors = explode(',', $allassignment->auditors);
            //Get rid of the last empty value
            $auditorscount = count($auditors) - 1;
            unset($auditors[$auditorscount]);
            $auditorsPerAssignment[$allassignment->id] = '';
            foreach ($auditors as $auditor) {
                $auditorsPerAssignment[$allassignment->id] = $auditorsPerAssignment[$allassignment->id] . '<span class="label label-danger"><i class="fa fa-bookmark fa-fw"></i> ' . ConsoleUser::getName($auditor) . '</span> ';
            }
            $categoriesPerAssignment[$allassignment->id] = '';
            $cats = $allassignment->categories;
            $cats = explode(',', $cats);
            //Remove the last empty value
            $catscount = count($cats) - 1;
            unset($cats[$catscount]);
            foreach ($cats as $cat ) {
                $categoriesPerAssignment[$allassignment->id] = $categoriesPerAssignment[$allassignment->id] . '<span class="label label-default">' . $catnames[$cat] . '</span> ';
            }
        }
        return View::make('console.assignments')->with(array('assignments' => $assignments, 'othersAssignments' => $othersassignments, 'categoriesPerAssignment' => $categoriesPerAssignment, 'auditorsPerAssignment' => $auditorsPerAssignment, 'vasList' => $vaslist));
    }

    public function get_assignmentsdelete($id) {
        //Verify the assignment exists
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();
        //Now just redirect back
        return Redirect::route('consoleassignments')->with('message', 'Assignment removed successfully.');
    }

    public function get_assignmentscomplete($assignment, $va) {
        //Ensure both variables are present
        if (empty($assignment) || empty($va))
            return Redirect::route('consoleassignments')->with('message', 'Missing GET parameters ($assignment, $va)');
        //Verify the assignment exists and this member is assigned to this assignment
        $assignment = Assignment::findOrFail($assignment);
        $assigned = explode(',', $assignment->auditors);
        if (!in_array(Auth::consoleuser()->get()->cid, $assigned))
            return Redirect::route('consoleassignments')->with('message', 'Permission Denied. Auditor not assigned to this assignment.');
        //Pull the VAs
        $vas = explode(',', $assignment->vas);
        //Remove the last empty value
        $vascount = count($vas) - 1;
        unset($vas[$vascount]);
        //Remove the matching value
        $key = array_search($va, $vas);
        unset($vas[$key]);
        //Check to see if we have any VAs left for auditting
        if (count($vas) == 0) {
            $assignment->delete();
            return Redirect::route('consoleassignments')->with('message', 'Audit completed. No VAs left to audit in this assignment. Assignment Completed Successfully. Assignment Removed.');
        }
        //Convert our array back to a string
        $vas = implode(',',  $vas) . ',';
        //Update the database
        $assignment->vas = $vas;
        $assignment->save();
        //Redirect back to the page.
        return Redirect::route('consoleassignments')->with('message', 'Audit completed. Assignment Updated Successfully.');
    }

    public function post_emailva($cid) {
        //Verify the VA CID is valid
        $va = User::findOrFail($cid);
        $email = $va->email;
        $subject = Input::get('inputSubject');
        $body = Input::get('inputBody');
        if (empty($subject) || empty($body))
            return Redirect::to('console/va/' . $cid . '#email')->with('message', 'Please enter a subject and body prior to sending the message.');
        //Replace the email body variables
        $body = EmailTemplate::replaceContent($body , $cid);
        $data = array('va' => $va, 'email' => $email, 'subject' => $subject);
        //Alright. Time to do some email sending.
        Mail::send('email.default', array("content" => $body), function($message) use ($data) {
            $message->to($data['va']->email, $data['va']->name)->subject($data['subject']);
        });
        //Hopefully all went well. Now just redirect back
        return Redirect::to('console/va/' . $cid . '#email')->with('message', 'Your email was sent successfully.');
    }

    public function get_profile() {
        //Pull the auditor
        $auditor = ConsoleUser::findOrFail(Auth::consoleuser()->get()->cid);
        //Create the view
        return View::make('console.profile')->with('auditor', $auditor);
    }

    public function post_profilesave() {
        //Get our inputs
        $name = Input::get('inputName');
        $email = Input::get('inputEmail');
        $ticketnotifications = Input::get('inputTicketNotifications');
        //Start the validator
        $validator = Validator::make(array(
            'name' => $name,
            'email' => $email,
            'ticketnotifications' => $ticketnotifications,
        ), array(
            'name' => 'required',
            'email' => 'required|email',
            'ticketnotifications' => 'required|in:0,1',
        ));
        if ($validator->fails())
            return Redirect::route('consoleprofile')->withErrors($validator);

        //Great validation passed. Now let's push these updates
        $auditor = ConsoleUser::findOrFail(Auth::consoleuser()->get()->cid);
        $auditor->name = $name;
        $auditor->email = $email;
        $auditor->ticketnotifications = $ticketnotifications;
        //Save
        $auditor->save();
        //Redirect back with message
        return Redirect::route('consoleprofile')->with('message', 'Profile Updated Successfully.');
    }

    public function get_systememailtemplatedit($id) {
        //Verify this is a valid ID
        $template = SystemEmailTemplate::findOrFail($id);
        //Return our view
        return View::make('console.emailtemplatesystemedit')->with('template', $template);
    }

    public function post_systememailtemplatesave() {
        //Get our data
        $id = Input::get('id');
        $subject = Input::get('subject');
        $content = Input::get('content');
        //Verify that this in fact a valid system template ID
        $template = SystemEmailTemplate::findOrFail($id);
        //I'm too lazy to use proper validation for this
        if (empty($subject)) {
            return Redirect::to('console/emailtemplates/edit/system/' . $id)->with('message', 'Please enter a subject.');
        }
        if (empty($content)) {
            return Redirect::to('console/emailtemplates/edit/system/' . $id)->with('message', 'Please enter an email body.');
        }
        //Alright all good let's push these edits
        $template->subject = $subject;
        $template->content = $content;
        $template->save();
        //Redirect back
        return Redirect::route('consoleemailtemplates')->with('message', 'System template "' . $id . '" updated successfully.');
    }

    public function get_stats() {
        //Todo in progress
        return View::make('console.stats');
    }

    public function post_vahiddencategoriessave() {
        $categories = Input::get('hiddenCategories');
        if(count($categories) >= 1){
            $categories = implode(',', $categories) . ',';
        }
        else {
            $categories = '';
        }
        //Pull the current categories
        $user = User::findOrFail(Input::get('cid'));
        $currentCategoriesstr = $user->categories;
        //Let's see if we already have some hidden categories buried in there.
        $currentCategories = explode(',', $currentCategoriesstr);
        array_pop($currentCategories);
        if (Category::isHiddenCategory($currentCategories)) {
            //Damn it to hell. More work for us. There are hidden categories already there so we first need to find and remove them and then add the selected ones
            $allHiddenCategories = Category::where('hidden', '=', '1')->get();
            $allHiddenCategoryIds = array();
            foreach ($allHiddenCategories as $allHiddenCategory) {
                $allHiddenCategoryIds[] = $allHiddenCategory->id . ',';
            }
            $currentCategories = str_replace($allHiddenCategoryIds, '', $currentCategoriesstr);
            //Great now all of the hidden categories are gone. Let's just append our selected ones to the end of it
            $currentCategories = $currentCategories . $categories;
        }
        else {
            //Sweet jesus. We can just add the newly selected ones
            $currentCategories = $currentCategoriesstr . $categories;
        }
        $user->categories = $currentCategories;
        $user->save();
        //Wow that was fucking painful and it is now 2:06 AM.
        return Redirect::to('console/va/' . Input::get('cid') . '#categories')->with('message', 'Hidden Categories Saved Successfully.');

    }

    public function post_flagvaawaitingresponse() {
        $vaid = Input::get('vaid');
        //Verify this is a valid VA
        $va = User::findOrFail($vaid);
        $va->awaiting_response = 1;
        $va->save();
    }

    public function post_flagvaawaitingresponsedelete() {
        $vaid = Input::get('vaid');
        //Verify this is a valid VA
        $va = User::findOrFail($vaid);
        $va->awaiting_response = 0;
        $va->save();
    }


    //Admin maintenance functions

    public function get_adminimport() {
        //Make sure I am the only one using this tool
        if (Auth::consoleuser()->get()->cid != "1095510")
            App::abort('403');
        $filename = public_path() . '/import/current.csv';
        $delimiter = ',';
        ini_set('auto_detect_line_endings',TRUE);
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if (!$header) {
                    $header = $row;
                }
                else {
                    if (count($header) > count($row)) {
                        $difference = count($header) - count($row);
                        for ($i = 1; $i <= $difference; $i++) {
                            $row[count($row) + 1] = $delimiter;
                        }
                    }
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        $i = 0;
        //We need to get a list of all current VA cids to make sure that we aren't importing a VA that we already imported
        $currentvas = User::all();
        $currentvaids = array();
        foreach ($currentvas as $currentva) {
            $currentvaids[] = $currentva->cid;
        }
        foreach ($data as $va) {
            if (!is_numeric($va['id']) || in_array($va['id'], $currentvaids)) {
                continue;
            }
            $user = new User();
            $user->cid = $va['id'];
            $user->vaname = $va['sitename'];
            $user->url = $va['url'];
            $user->description = $va['description'];
            $user->vatsimimagepagelink = $va['recip_page'];
            $user->country = $va['country'];
            $user->stateprovince = $va['state'];
            $user->city = $va['city'];
            $user->zip = $va['zip'];
            $user->name = $va['name'];
            $user->email = $va['email'];
            //0 for pending and 1 for active
            $user->status = '1';
            if ($va['reciprocating'] == "YES")
                $user->linkbackstatus = '1';
            else
                $user->linkbackstatus = '0';
            $user->categories = '';
            $categoryArray = array($va['category1'], $va['category2'], $va['category3'], $va['category4'], $va['category5'], $va['category6'], $va['category7'], $va['category8'], $va['category9']);
            $findArray = array('[1];Virtual Airlines', '[2];Africa - Middle East', '[3];Asia', '[4];North America', '[5];Europe', '[6];Oceania', '[7];South America', '[8];Central America / Caribbean / Mexico', '[9];Airline Alliances', '[17];Cargo Only VAs', '[18];Helicopter Only VAs', '[19];Historical VAs', '[20];General Aviation VAs/Flying Clubs', '[21];XPlane VAs', '[22];Heritage Virtual Airlines', '[16];Authorized Training Organizations');
            $replaceArray = array('2', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '5', '4');
            foreach ($categoryArray as $category) {
                $category = str_replace($findArray, $replaceArray, $category);
                if (in_array($category, $replaceArray))
                    $user->categories = $user->categories . $category . ',';
            }
            //Save the user
            $user->save();

            //Now insert the current comments as one audit log entry
            $auditlog = new AuditLog();
            $auditlog->va = $va['id'];
            $auditlog->author = '800000';
            $auditlog->content = $va['comments'];
            $auditlog->save();
            $i++;
        }
        echo "Inserted " . $i . ' new records';
    }

    public function get_adminbannerimport() {
        //Make sure I am the only one using this tool
        if (Auth::consoleuser()->get()->cid != "1095510")
            App::abort('403');
        $filename = public_path() . '/import/pending.csv';
        $delimiter = ',';
        ini_set('auto_detect_line_endings',TRUE);
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if (!$header) {
                    $header = $row;
                }
                else {
                    if (count($header) > count($row)) {
                        $difference = count($header) - count($row);
                        for ($i = 1; $i <= $difference; $i++) {
                            $row[count($row) + 1] = $delimiter;
                        }
                    }
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        $i = 0;
        foreach ($data as $va) {
            if (!is_numeric($va['id'])) {
                continue;
            }
            //Find our user
            $user = User::find($va['id']);
            //Make sure this is a valid va
            if (empty($va) || !empty($va->banner))
                continue;
            //Pull our banner (prepend 'pend' to the image name when importing pending links)
            $url = "http://linksmanager.com/b/vatsimvas/" . $va['id'] . ".gif";
            $saveto = public_path() . '/banners/' . $va['id'] . '.gif';
            //Save the banner
            $ch = curl_init ($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
            $raw=curl_exec($ch);
            $info = curl_getinfo($ch);
            if ($info['content_type'] != 'image/gif')
                continue;
            curl_close ($ch);
            if(file_exists($saveto)){
                unlink($saveto);
            }
            $fp = fopen($saveto,'x');
            fwrite($fp, $raw);
            fclose($fp);

            //Now update the db
            $user->banner = $va['id'] . '.gif';
            $user->save();
            $i++;
        }
        echo 'A total of ' . $i . ' banners imported';
    }


}
