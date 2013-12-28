<?php
class VaController extends BaseController {

    public function get_va() {
        //Pull our users VA data
        $record = User::where('cid', '=', Auth::user()->cid)->first();

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
        $month = Click::where('created_at', '>=', $month)->where('vid', '=', Auth::user()->cid)->count();
        //Where data is greater than the first of last month, but less than the first of this month and is associated with our logged in user.
        $month1before = Click::where('created_at', '>=', $month1before)->where('created_at', '<', $month)->where('vid', '=', Auth::user()->cid)->count();
        //You get the point :)
        $month2before = Click::where('created_at', '>=', $month2before)->where('created_at', '<', $month1before)->where('vid', '=', Auth::user()->cid)->count();
        $month3before = Click::where('created_at', '>=', $month3before)->where('created_at', '<', $month2before)->where('vid', '=', Auth::user()->cid)->count();
        //Add to our clicks array.
        $clicks['month'] = $month;
        $clicks['month1before'] = $month1before;
        $clicks['month2before'] = $month2before;
        $clicks['month3before'] = $month3before;

        //Pull our ticket information
        $opentickets = Ticket::where('vid', '=', Auth::user()->cid)->where('status', '=', '1')->orderBy('created_at', 'DESC')->get();
        $openticketscount = count($opentickets);
        $closedtickets = Ticket::where('vid', '=', Auth::user()->cid)->where('status', '=', '0')->orderBy('created_at', 'DESC')->get();
        $closedticketscount = count($closedtickets);
        //Create our array
        $tickets = array();
        $tickets['opentickets'] = $opentickets;
        $tickets['opentickets_count'] = $openticketscount;
        $tickets['closedtickets'] = $closedtickets;
        $tickets['closedtickets_count'] = $closedticketscount;
        //Pull our ticket_reply information using the relationship defined in the model
        $cid = Auth::user()->cid;
        $replies = TicketReply::whereHas('ticket', function($q) use ($cid) {
            $q->where('vid', '=', $cid);
        })->get();
        $tickets['replies'] = $replies;

        //Create our view with the VA, clicks and tickets data.
        return View::make('va')->with(array('record' => $record, 'clicks' => $clicks, 'tickets' => $tickets));
    }

}