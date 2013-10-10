<?php
/*
|--------------------------------------------------------------------------
| IoC Containers
|--------------------------------------------------------------------------
|
| An IoC container is simply a way of managing the creation of objects. You 
| can use it to define the creation of complex objects, allowing you to 
| resolve them throughout your application using a single line of code. You 
| may also use it to "inject" dependencies into your classes and controllers.
|
*/

IoC::register('user_cache', function( $username ){

	// First attempt to fetch the cached record. If one is not existent
	// then we will need to generate one.
	// 
	return Cache::get( $username . '_user_data', function() use( $username ){

		// Fetch the user data from the db
		// 
		$userData = User::where_username( $username )->first();

		// Place the data forever into cache
		// 
		Cache::forever( $username . '_user_data', $userData );

		// Return the data
		// 
		return $userData;
	});
});