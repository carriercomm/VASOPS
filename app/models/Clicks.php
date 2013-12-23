<?php

class Clicks extends Eloquent {

    public $table = 'clicks';

    //We want to use unix time stamps for this table
    protected function getDateFormat()
    {
        return time();
    }

}