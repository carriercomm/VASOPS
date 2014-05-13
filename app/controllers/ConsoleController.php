<?php
class ConsoleController extends BaseController {

    public function get_logout() {
        //Log the user out
        Auth::consoleuser()->logout();
        //Redirect to the login page with a message
        return Redirect::route('consolelogin')->with('message', 'You have been successfully logged out.');
    }

    public function get_login()

    {
        return View::make('console.login');
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
                'Password' => 'required',
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

            $consoleuser = ConsoleUser::where('cid', '=', $cid)->first();
            if (!empty($consoleuser)) {
                //User with the provided CID exists. Now let's run the password
                if (Hash::check($password, $consoleuser->password)) {
                    //Credentials were valid. Let's login the user
                    Auth::consoleuser()->loginUsingId($cid);
                    //We will now redirect them to the console index
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
        $unreadTickets = Ticket::where('status', '=', '1')->where('seen_by', 'not like', '%' . $cid . ',%')->get();
        //Pull a list of our Ticket IDs
        //Now that we have the list of tickets, let's pull the latest reply if there is one.
        $unreadHelpDesk = array();
        foreach ($unreadTickets as $unreadTicket) {
            $replyCount = TicketReply::where('tid', '=', $unreadTicket->id)->orderBy('created_at', 'ASC')->count();
            if ($replyCount > 0) {
                $unreadHelpDesk[$unreadTicket->id] = TicketReply::where('tid', '=', $unreadTicket->id)->orderBy('created_at', 'ASC')->first();
                $unreadHelpDesk[$unreadTicket->id]['subject'] = $unreadTicket->subject;
                $unreadHelpDesk[$unreadTicket->id]['type'] = '2';
                $unreadHelpDesk[$unreadTicket->id]['ticket_author'] = $unreadTicket->vid;
            }
            else {
                $unreadHelpDesk[$unreadTicket->id] = $unreadTicket;
                $unreadHelpDesk[$unreadTicket->id]['type'] = '1';
            }
        }
        $pendingVAs = User::where('status', '=', '0')->orderBy('created_at', 'ASC')->get();
        $activeBroadcasts = Broadcast::where('status', '=', '1')->orderBy('created_at', 'DESC')->get();
        return View::make('console.index')->with(array('pendingVAs' => $pendingVAs, 'activeBroadcasts' => $activeBroadcasts, 'tickets' => $unreadHelpDesk));
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
            $vas = User::where('name', 'like', $like)->orWhere('vaname', 'like', $like)->orWhere('url', 'like', $like)->orderBy('vaname', 'ASC')->get();
        }

        if (count($vas) > 0) {
            //Format our output
            $send = '';
            foreach ($vas as $va) {
                $send .= "<tr><td>$va->vaname</td><td>$va->url</td><td>$va->cid</td><td>$va->name</td><td>$va->created_at</td><td><a href=\"" . URL::route('console') .  "/va/$va->cid\"><i class=\"fa fa-edit fa-fw\"</a></td></tr>";
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
        return View::make('console.va')->with(array('va' => $va, 'banner' => $banner, 'audit_log' => $audit_log, 'banner_maxwidth' => $banner_maxwidth, 'banner_maxheight' => $banner_maxheight));
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
                $tickets = Ticket::where('assigned', '=', Auth::consoleuser()->get()->cid)->get();
                break;
        }



        return View::make('console.helpdesk')->with(array('subheader' => $subheader, 'tickets' => $tickets));

    }

    public function get_emailtemplates() {
        return View::make('console.emailtemplates')->with(array());
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
                return Redirect::to('console/va/' . $cid);
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
        return Redirect::to('console/va/' . $cid);
    }

}