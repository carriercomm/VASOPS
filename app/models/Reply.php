<?php

class Reply extends Eloquent {

    public $table = 'ticket_replies';

    public function ticket()
    {
        return $this->belongsTo('Ticket', 'id', 'tid');
    }

}