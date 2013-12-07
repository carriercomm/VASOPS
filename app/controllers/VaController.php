<?php
class VaController extends BaseController {

    public function get_va() {
        //Pull our users VA data
        $record = User::where('cid', '=', Auth::user()->cid)->first();
        //Create our view with the record
        return View::make('va')->with(array('record' => $record));
    }

}