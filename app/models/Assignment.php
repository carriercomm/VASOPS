<?php

class Assignment extends Eloquent {

    protected $table = "assignments";

    static public function get_NumAssignments($cid="") {
        if (empty($cid))
            $cid = Auth::consoleuser()->get()->cid;
        $assignmentscount = Assignment::where('auditors', 'like', '%' . $cid . ',%')->count();
        return $assignmentscount;
    }

    static public function getReadableStatus($status) {
        if ($status = 0)
            $return = 'Pending';
        if ($status = 1)
            $return = 'In Progress';
        else
            $return = 'Unknown';
        return $return;
    }

}