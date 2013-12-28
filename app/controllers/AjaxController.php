<?php
class AjaxController extends BaseController {

    public function post_logout() {
        Auth::logout();
    }

    public function post_login() {
        $postStr = Input::get('data');
        parse_str($postStr, $post);
        $cid = $post['inputCid'];
        $password = $post['inputPassword'];
        $user = User::where('cid', '=', $cid)->first();
        if (!empty($user)) {
           if (Hash::check($password, $user->password)) {
               Auth::loginUsingId($cid);
               $fname = User::getFirstName(Auth::user()->cid);
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
            $vas = User::find(Auth::user()->cid);
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
        $ticket = Tickets::where('id', '=', $ticketid)->where('vid', '=', Auth::user()->cid)->first();
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
        $ticket = Tickets::where('id', '=', $ticketid)->where('vid', '=', Auth::user()->cid)->first();
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
            $ticket = new Tickets;
            $ticket->subject = $post['inputTicketSubject'];
            $ticket->description = $post['inputTicketContent'];
            $ticket->vid = Auth::user()->cid;
            //Our ticket status will start as open.
            $ticket->status = '1';
            $ticket->save();
            //Pull the newly created ticket ID.
            $ticket = Tickets::where('vid', '=', Auth::user()->cid)->orderBy('id', 'DESC')->first();
            $id = $ticket->id;
            echo $id;
        }

    }

}