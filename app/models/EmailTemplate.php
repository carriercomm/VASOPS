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

    /**
     * replaceContent()
     * Returns the email content as a string with the appropriate reference variables replaced with the dynamic values
     * @param string $content
     * @param int $user
     * @return string
     */

    public static function replaceContent($content, $user) {
        $user = User::findOrFail($user);
        $variables = array("[name]", "[vaname]", "[cid]", "[email]", "[auditorname]");
        $values = array($user->name, $user->vaname, $user->cid, $user->email, Auth::consoleuser()->get()->name);
        $content = str_replace($variables, $values, $content);
        return $content;
    }

}