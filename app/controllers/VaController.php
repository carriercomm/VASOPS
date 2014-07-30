<?php
class VaController extends BaseController {

    public function get_va() {
        //Pull our users VA data
        $record = User::where('cid', '=', Auth::user()->get()->cid)->first();

        //Figure out what the last 4 months are and append -1 for the first day of the month
        $month = date('Y-m');
        $month .= '-1';
        $month1before = date('Y-m', strtotime('-1 month'));
        $month1before .= '-1';
        $month2before = date('Y-m', strtotime('-2 month'));
        $month2before .= '-1';
        $month3before = date('Y-m', strtotime('-3 month'));
        $month3before .= '-1';
        //Convert to unix time stamps to compare with the DB
        $month = strtotime($month);
        $month1before = strtotime($month1before);
        $month2before = strtotime($month2before);
        $month3before = strtotime($month3before);

        //Now let's store our month names in an array
        $clicks = array();
        $clicks['month_name'] = date("F", $month);
        $clicks['month1before_name'] = date("F", $month1before);
        $clicks['month2before_name'] = date("F", $month2before);
        $clicks['month3before_name'] = date("F", $month3before);


        //Count the data in the DB
        //Where data is greater than the first of this month and is associated with our logged in user.
        $month = Click::where('created_at', '>=', $month)->where('vid', '=', Auth::user()->get()->cid)->count();
        //Where data is greater than the first of last month, but less than the first of this month and is associated with our logged in user.
        $month1before = Click::where('created_at', '>=', $month1before)->where('created_at', '<', $month)->where('vid', '=', Auth::user()->get()->cid)->count();
        //You get the point :)
        $month2before = Click::where('created_at', '>=', $month2before)->where('created_at', '<', $month1before)->where('vid', '=', Auth::user()->get()->cid)->count();
        $month3before = Click::where('created_at', '>=', $month3before)->where('created_at', '<', $month2before)->where('vid', '=', Auth::user()->get()->cid)->count();
        //Add to our clicks array.
        $clicks['month'] = $month;
        $clicks['month1before'] = $month1before;
        $clicks['month2before'] = $month2before;
        $clicks['month3before'] = $month3before;

        //Pull our ticket information
        $opentickets = Ticket::where('vid', '=', Auth::user()->get()->cid)->where('status', '=', '1')->orderBy('created_at', 'DESC')->get();
        $openticketscount = count($opentickets);
        $closedtickets = Ticket::where('vid', '=', Auth::user()->get()->cid)->where('status', '=', '0')->orderBy('created_at', 'DESC')->get();
        $closedticketscount = count($closedtickets);
        //Create our array
        $tickets = array();
        $tickets['opentickets'] = $opentickets;
        $tickets['opentickets_count'] = $openticketscount;
        $tickets['closedtickets'] = $closedtickets;
        $tickets['closedtickets_count'] = $closedticketscount;

        //Pull our replies
        $tickets_request = Ticket::where('vid', '=', Auth::user()->get()->cid)->get();
        $tids = array();
        foreach ($tickets_request as $ticket_request) {
            $tid = $ticket_request->id;
            $tids[$tid] = $tid;
        }
        if (!empty($tids))
            $replies = TicketReply::whereIn('tid', $tids)->orderBy('created_at', 'ASC')->get();
        else
            $replies = '';
        $tickets['replies'] = $replies;

        //Pull our Category data
        $categories = Category::get();

        //Check to see if there is a banner if so provide the source for it
        if ($record->banner) {
            $banner = User::getBannerUrl(Auth::user()->get()->cid);
        }
        else {
            //No banner we will set this as false so the views no not to try and display it.
            $banner = FALSE;
        }


        //Create our view with the VA, clicks, categories and tickets data.
        return View::make('va')->with(array('record' => $record, 'clicks' => $clicks, 'tickets' => $tickets, 'categories' => $categories, 'banner' => $banner));
    }

    public function post_uploadbanner() {
        //Verify we have a file
        if (Input::hasFile('inputBanner')) {
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
                $fileName = Auth::user()->get()->cid . $extension;
                $banner->move($destinationPath, $fileName);
                //Finally update the db with the new banner name.
                $va = User::where('cid', '=', Auth::user()->get()->cid)->first();
                $va->banner = $fileName;
                $va->save();
                //Redirect the user back to the banner page
                return Redirect::to(route('va') . '#banner');

            }
            else {
                //Time to abort.
                App::abort(400, 'Invalid file type.');
            }

        }

    }

}