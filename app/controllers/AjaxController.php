<?php
class AjaxController extends BaseController {

    public function post_logout() {
        Auth::user()->logout();
    }

    public function post_login() {
        $postStr = Input::get('data');
        parse_str($postStr, $post);
        $cid = $post['inputCid'];
        $password = $post['inputPassword'];
        $user = User::where('cid', '=', $cid)->first();
        if (!empty($user)) {
           if (Hash::check($password, $user->password)) {
               Auth::user()->loginUsingId($cid);
               $fname = User::getFirstName(Auth::user()->get()->cid);
               Session::put('fname', $fname);
               echo $fname;
            }
            else {
                echo "/errorBadPassword";
            }
        }
        else {
            echo "/errorBadCid";
        }
    }

    public function post_vaedit() {
        //Pull our AJAX data
        $postStr = Input::get('data');
        //Parse the serialized string
        parse_str($postStr, $post);
        //      Laravel gets mad and throws an error if category isn't defined so let's go ahead and just define it but leave it empty.
        if (empty($post['inputCategory'])) {
            $post['inputCategory'] = '';
        }

        //      Format our URL field with the http before if it isn't there already (Must evaluate with ===)
        if (strpos($post['inputUrl'],'http://') === FALSE AND strpos($post['inputUrl'],'https://') === FALSE) {
            $post['inputUrl'] = 'http://' . $post['inputUrl'];
        }

        //      Start our validator
        $validator = Validator::make(
            array(
                'Va Name' => $post['inputVaName'],
                'Url' => $post['inputUrl'],
                'Description' => $post['inputDescription'],
                'Vatsim Image Page Link' => $post['inputVatsimImagePageLink'],
                'Country' => $post['inputCountry'],
                'State/Province' => $post['inputStateProvince'],
                'City' => $post['inputCity'],
                'Zip' => $post['inputZip'],
                'Name' => $post['inputName'],
                'Email' => $post['inputEmail'],
                'Password' => $post['inputPassword'],
                'Password_confirmation' => $post['inputPassword_confirmation'],
                'Category' => $post['inputCategory'],
            ),
            array(
                'Va Name' => 'required',
                'Url' => 'required|url',
                'Description' => 'required|max:200',
                'Vatsim Image Page Link' => 'required|url',
                'Country' => 'required',
                'State/Province' => 'required',
                'City' => 'required',
                'Zip' => 'required',
                'Name' => 'required',
                'Email' => 'required|email',
                'Password' => 'min:6|confirmed',
                'Password_confirmation' => 'min:6',
                'Category' => 'required|max:5',
            ),
            array (
                'Category.max' => 'You have selected more than :max categories.',
                'Cid.unique' => 'There is already an account with an active virtual airline with that CID.',
            )
        );

        if ($validator->fails())
        {
            // The given data did not pass validation
            $messages = $validator->messages();
            $errorStr = '';
            foreach ($messages->all('<li>:message</li>') as $message)
            {
                $errorStr .= '<div class="alert alert-error">'. $message . '</div>';
            }
            echo $errorStr;

        }
        else {

            //Pull our current VA record
            $vas = User::find(Auth::user()->get()->cid);
            //Map our fields
            //Hash our password if one is inputted
            if (!empty($post['inputPassword'])) {
                $vas->password = Hash::make($post['inputPassword']);
            }
            $vas->vaname = $post['inputVaName'];
            $vas->url = $post['inputUrl'];
            $vas->description = $post['inputDescription'];
            $vas->vatsimimagepagelink = $post['inputVatsimImagePageLink'];
            $vas->country = $post['inputCountry'];
            $vas->stateprovince = $post['inputStateProvince'];
            $vas->city = $post['inputCity'];
            $vas->zip = $post['inputZip'];
            $vas->name = $post['inputName'];
            $vas->email = $post['inputEmail'];
            $vas->categories = implode (",", $post['inputCategory']);
            //Save our data
            $vas->save();


        }

    }

    public function post_registration()
    {
        //Pull our AJAX post data
        $postStr = Input::get('data');
        //Parse the serialized string
        parse_str($postStr, $post);
//      Laravel gets mad and throws an error if category isn't defined so let's go ahead and just define it but leave it empty.
        if (empty($post['inputCategory'])) {
            $post['inputCategory'] = '';
        }
//      Format our URL field with the http before if it isn't there already
        if (!strpos($post['inputUrl'],'http://') AND !strpos($post['inputUrl'],'https://')) {
            $post['inputUrl'] = 'http://' . $post['inputUrl'];
        }

//      Start our validator
        $validator = Validator::make(
            array(
                'Cid' => $post['inputCid'],
                'Va Name' => $post['inputVaName'],
                'Url' => $post['inputUrl'],
                'Description' => $post['inputDescription'],
                'Vatsim Image Page Link' => $post['inputVatsimImagePageLink'],
                'Country' => $post['inputCountry'],
                'State/Province' => $post['inputStateProvince'],
                'City' => $post['inputCity'],
                'Zip' => $post['inputZip'],
                'Name' => $post['inputName'],
                'Email' => $post['inputEmail'],
                'Password' => $post['inputPassword'],
                'Password_confirmation' => $post['inputPassword_confirmation'],
                'Category' => $post['inputCategory'],
            ),
            array(
                'Cid' => 'required|integer|unique:vas,cid',
                'Va Name' => 'required',
                'Url' => 'required|url',
                'Description' => 'required|max:200',
                'Vatsim Image Page Link' => 'required|url',
                'Country' => 'required',
                'State/Province' => 'required',
                'City' => 'required',
                'Zip' => 'required',
                'Name' => 'required',
                'Email' => 'required|email',
                'Password' => 'required|min:6|confirmed',
                'Password_confirmation' => 'required|min:6',
                'Category' => 'required|max:5',
            ),
            array (
                'Category.max' => 'You have selected more than :max categories.',
                'Cid.unique' => 'There is already an account with an active virtual airline with that CID.',
            )
        );

        if ($validator->fails())
        {
            // The given data did not pass validation
            $messages = $validator->messages();
            $errorStr = '';
            foreach ($messages->all('<li>:message</li>') as $message)
            {
                $errorStr .= '<div class="alert alert-error">'. $message . '</div>';
            }
            echo $errorStr;

        }
        else {

            //Submit Data
            //Create an instance of our model
            $vas = new User;
            //Map our fields
            $vas->cid = $post['inputCid'];
            //Hash our password
            $vas->password = Hash::make($post['inputPassword']);
            $vas->vaname = $post['inputVaName'];
            $vas->url = $post['inputUrl'];
            $vas->description = $post['inputDescription'];
            $vas->vatsimimagepagelink = $post['inputVatsimImagePageLink'];
            $vas->country = $post['inputCountry'];
            $vas->stateprovince = $post['inputStateProvince'];
            $vas->city = $post['inputCity'];
            $vas->zip = $post['inputZip'];
            $vas->name = $post['inputName'];
            $vas->email = $post['inputEmail'];
            $vas->categories = implode (",", $post['inputCategory']);
            //All VAs must be approved first so the default status will be 0 for unapproved or not active.
            $vas->status = '0';
            //Save our data
            $vas->save();

        }

    }

    public function post_closeticket() {
        //Pull our AJAX data
        $ticketid = Input::get('data');
        //Pull our ticket
        $ticket = Ticket::where('id', '=', $ticketid)->where('vid', '=', Auth::user()->get()->cid)->first();
        //Does this user own this ticket?
        if (count($ticket) == 1) {
            //Set our ticket status to 0 or closed
            $ticket->status = 0;
            //Save our update
            $ticket->save();
            echo "1";
        }
    }

    public function post_reopenticket() {
        //Pull our AJAX data
        $ticketid = Input::get('data');
        //Pull our ticket
        $ticket = Ticket::where('id', '=', $ticketid)->where('vid', '=', Auth::user()->get()->cid)->first();
        //Does this user own this ticket?
        if (count($ticket) == 1) {
            //Set our ticket status to 1 or open
            $ticket->status = 1;
            //Save our update
            $ticket->save();
            echo "1";
        }
    }

    public function post_newticket() {
        //Pull our AJAX Post Data
        $postStr = Input::get('data');
        //Parse the serialized string
        parse_str($postStr, $post);

        //      Start our validator
        $validator = Validator::make(
            array(
                'Subject' => $post['inputTicketSubject'],
                'Description' => $post['inputTicketContent'],
            ),
            array(
                'Subject' => 'required',
                'Description' => 'required',
            ),
            array (
                'Subject.required' => 'Please enter a subject. ',
                'Description.required' => 'Please enter a description.',
            )
        );

        if ($validator->fails())
        {
            // The given data did not pass validation
            $messages = $validator->messages();
            $errorStr = '';
            foreach ($messages->all('<li>:message</li>') as $message)
            {
                $errorStr .= '<div class="alert alert-error">'. $message . '</div>';
            }
            echo $errorStr;

        }

        else {
            $ticket = new Ticket;
            $ticket->subject = $post['inputTicketSubject'];
            $ticket->description = $post['inputTicketContent'];
            $ticket->vid = Auth::user()->get()->cid;
            //Our ticket status will start as open.
            $ticket->status = '1';
            $ticket->save();
            //Pull the newly created ticket ID.
            $ticket = Ticket::where('vid', '=', Auth::user()->get()->cid)->orderBy('id', 'DESC')->first();
            $id = $ticket->id;
            echo $id;
        }

    }

    public function post_replyticket() {
        $postStr = Input::get('data');
        parse_str($postStr, $post);

        $validator = Validator::make(
           array (
               'Reply' => $post['inputReplyTicket'],
               'tid' => $post['tid'],
           ),
           array (
              'Reply' => 'required',
              'tid' => 'required|integer',
           ),
           array (
               'Reply.required' => 'Please enter a reply.',
               'tid.required' => 'The system cannot find a ticket to reply to.',
               'tid.integer' => 'The system has been sent an invalid ticket id to reply to.',
           )
        );

        //Verify some smart ass didn't try to change the hidden input field (tid) or reply to a closed ticket.
        $count = Ticket::where('id', '=', $post['tid'])->where('vid', '=', Auth::user()->get()->cid)->where('status', '=', '1')->count();
        if ($count == 0) {
            //Damn them.
            echo '<div class="alert alert-error"><li>Seriously? Nice try.</li></div>';
        }


        if ($validator->fails()) {
            $messages = $validator->messages();
            $errorStr = '';
            foreach ($messages->all('<li>:message</li>') as $message)
            {
                $errorStr .= '<div class="alert alert-error">'. $message . '</div>';
            }
            echo $errorStr;
        }

        else {
            $reply = new Reply;
            $reply->tid = $post['tid'];
            $reply->author = Auth::user()->get()->cid;
            $reply->content = $post['inputReplyTicket'];
            //Save our ticket update
            $reply->save();
            //Return 1 to inform the client this was successful.
            echo '1';
        }

    }

    public function post_checkimagelinkback() {
        $url = Auth::user()->get()->vatsimimagepagelink;
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $content = curl_exec($ch);
        curl_close($ch);
        $needle = 'vatsim.net';
        if (stripos($content, $needle) !== FALSE) {
            //The content was found update the database and return 1 to the client
            $va = User::where('cid', '=', Auth::user()->get()->cid)->first();
            $va->linkbackstatus = 1;
            $va->save();
            if ($va->status == 1) {
                //We will echo 1! to tell the client to replace the module icon to a check instead of the red X because there VA is now approved
                echo '1!';
            }
            else {
                echo '1';
            }

        }
        else {
            //The content was not found return 0 to the client.
             echo '0';
        }
    }

    public function post_getvasbycategory() {
        $categoryName = Input::get('data');
        $category = Category::where('name', '=', $categoryName)->first();
        $categoryId = $category->id;
        $vas = User::where('categories', 'like','%' . $categoryId . ',%')->where('status', '=', '1')->where('linkbackstatus', '=', '1')->get();
        if (count($vas) == 0) {
            echo '<h4>No Virtual Airlines Found.</h4>';
        }
        else {
            $output = '';
            foreach ($vas as $va) {
                $va->description = html_entity_decode($va->description);
                $va->vaname = html_entity_decode($va->vaname);
                $va->url = html_entity_decode($va->url);
                $output .= '<div class="well"><a target="_blank" href="' . URL::to('/click') . '/' .  $va->cid . '"><h4>' . $va->vaname . '</h4></a><blockquote style="margin-top: 4px;">'. $va->description . '</blockquote></div>';
            }
            echo $output;
        }

    }

}