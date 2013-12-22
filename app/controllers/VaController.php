<?php
class VaController extends BaseController {

    public function get_va() {
        //Pull our users VA data
        $record = User::where('cid', '=', Auth::user()->cid)->first();

        //Figure out what the last 4 months are
        $month = date('m');
        $month1before = date('m', strtotime('-1 month'));
        $month2before = date('m', strtotime('-2 month'));
        $month3before = date('m', strtotime('-3 month'));

        //Create our view with the record
        return View::make('va')->with(array('record' => $record));
    }

}