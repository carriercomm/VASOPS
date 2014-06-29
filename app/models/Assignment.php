<?php

class Assignment extends Eloquent {

    protected $table = "assignments";

    static public function get_NumAssignments($cid="") {
        if (empty($cid))
            $cid = Auth::consoleuser()->get()->cid;
        $assignmentscount = Assignment::where('auditors', 'like', '%' . $cid . ',%')->count();
        return $assignmentscount;
    }

}