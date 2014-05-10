<?php

class AuditLog extends Eloquent {

    protected $table = "audit_log";

    static public function createNotation($va, $content, $author = '') {
        if (empty($author))
            $author = Auth::consoleuser()->get()->cid;

        $audit_log = new AuditLog;
        $audit_log->author = $author;
        $audit_log->va = $va;
        $audit_log->content = $content;
        $audit_log->save();
    }

}