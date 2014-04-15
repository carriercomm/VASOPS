<?php

class Setting extends Eloquent {
    public $table = "settings";

    public $timestamps = False;

    protected $primaryKey = 'name';

    /**
     * update() Update a database setting
     * @var string, Current setting name to update
     * @var string, setting name
     * @var string, New value for the setting
     *
     * @return boolean
     */

    public static function updateSetting($name, $newvalue) {
        //All clear now, now to the fun stuff. We are going to pull our current setting
        $setting = Setting::find($name);
        //Declare our new property values
        $setting->value = $newvalue;
        //Finally update the db
        $setting->save();
        //The response everyone is looking for :)
        return true;
    }

    /**
     * fetch() Fetch and return a current database value
     * @var string, Setting name to fetch the value of
     *
     * @return string, The current setting value
     * */

    public static function fetch($name) {
        $setting = Setting::findOrFail($name);
        $value = $setting->value;
        return $value;
    }
}