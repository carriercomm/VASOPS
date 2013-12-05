<?php
class VaController extends BaseController {

    public function get_va() {

        return View::make('va')->with(array('fname' => $fname));
    }

}