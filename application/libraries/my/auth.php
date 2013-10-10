<?php

abstract class My_Auth
{
	/**
	 * Fetch the user's record cache.
	 * 
	 * @return array
	 */
	public static function user()
	{
        return IoC::resolve( 'user_cache', array( Auth::user()->username ) );
	}

	/**
	 * Determine if the logged in user is a website administrator.
	 * 
	 * @return boolean
	 */
	public static function isAdmin()
	{
		return in_array( Auth::user()->username, Config::get( 'admin.usernames' ) );
	}

	/**
	 * Check if the user is logged in and is a user.
	 * 
	 * @return boolean
	 */
	public static function checkIsAdmin()
	{
		return ( Auth::check() && self::isAdmin() );
	}
}