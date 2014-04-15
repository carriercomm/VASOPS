<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'vas';
    protected $primaryKey = 'cid';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

    public static function getFirstName($id) {
        $user = User::find($id);
        return strstr($user->name," ", true);
    }
    public static function getFullName($id) {
        $user = User::find($id);
        return $user->name;
    }

    public static function getBannerURL($cid) {
        $user = User::findOrFail($cid);
        //Remove trailing slash, if present, and readd.
        $banner_directory = rtrim(Setting::fetch('banner_directory'), '/').'/';
        //Add the current file update time to the end of the image link so that the browser will not cache the image if it is newer then what is previously loaded.
        $bannerurl = URL::to('/') . $banner_directory . $user->banner . '?last_picture_update=' . filemtime(public_path() . $banner_directory . $user->banner);
        return $bannerurl;
    }


}