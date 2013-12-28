<?php

class Ticket extends Eloquent {

    public $table = 'tickets';

    //Define the relationship of our replies model.
    public function replies() {

        return $this->hasMany('Ticket_Reply', 'tid', 'id');

    }

}