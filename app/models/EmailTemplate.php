<?php

class EmailTemplate extends Eloquent {

    protected $table = "email_templates";

    /**
     * sharedTemplates()
     * Returns a query object of all the shared templates by default excluding the shared templates authored by the current user.
     * @param bool $showall
     * @return mixed
     */
    public static function sharedTemplates($showall = FALSE) {
        if ($showall)
            $query = EmailTemplate::where('public', '=', '1')->orderBy('name', 'ASC')->get();
        else
            $query = EmailTemplate::where('public', '=', '1')->where('author', '!=', Auth::consoleuser()->get()->cid)->orderBy('name', 'ASC')->get();
        return $query;
    }

}