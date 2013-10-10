<?php

class Auth_Controller extends Base_Controller
{
	/**
	 * User Login Form
	 * 
	 * @return View
	 */
	public function get_login()
	{
		// Redirect to MSDS search page if the user is already logged in.
		// 
        if( Auth::check() ) return Redirect::to_route('msds');

		// Show the page
		// 
		return View::make('auth.login')->nest('form', 'auth.login.form');
	}

    /**
     * Process the user login form.
     * 
     * @return Redirect
     */
    public function post_login()
    {        
        // Define the validation rules
        // 
        $rules = array(
            'username'  => 'required|alpha_dash',
            'password'  => 'required|alpha_dash'
        );

        // Create a Validator instance and validate the data
        // 
        $validation = Validator::make( Input::all(), $rules );

        // {{ Passed Validation }}
        // 
        if( $validation->passes() )
        {
            // Set the credentials for authentication
            // 
            $credentials = array(
                'username' => Input::get('username'),
                'password' => Input::get('password'),
            );

            // Attempt to validate ldap user credentials
            try { Auth::driver('ldapauth')->attempt( $credentials ); }

            // Exception handling
            catch ( Exception $exc )
            {
                // Failed authentication...send back to the login
                // 
                return Redirect::back()->with('login_errors', true)->with_input();  
            }

            // Prepare our data for the session (and potential new user record).
            // 
            $data = array(
                'firstname' => Auth::user()->firstname,
                'lastname'  => Auth::user()->lastname,
                'name'      => Auth::user()->name,
                'email'     => Auth::user()->email,
                'username'  => Auth::user()->username
            );

            // Check if user already exists in our database
            // 
            $user_check = User::where_email( Auth::user()->email )->first();

            // User does not exist in the users table.
            // 
            if( is_null( $user_check ) )
            {
                // Create new User instance
                $user = new User($data);

                // Save new user record
                $user->save();
            }

            // Loop through our data and place it in the sessions.
            // 
            foreach( $data as $key => $value )
            {
                // Place the data in the session.
                Session::put($key, $value);   
            } 

            // Log the user out if they are not an admin.
            // 
            if( ! My_Auth::isAdmin() )
            {
                // Log the user out of their account
                // 
                Auth::logout();

                // Redirect to the homepage along with error message.
                // 
                return Redirect::to_route('home')->with('error', 'Only administrators are allowed to log in.');
            }

            // User attempted to access specific URL before logging in
            // 
            if( Session::has('pre_login_url') )
            {
                // Fetch and assign the url from the session.
                // 
                $url = Session::get('pre_login_url');   
                
                // Remove the pre_login_url form the session data.
                // 
                Session::forget('pre_login_url');
                
                // Redirect user
                // 
                return Redirect::to($url);
            }

            // Redirect user to the msds search page
            // 
            return Redirect::to_route('home');
        }

        // {{ Failed Authentication}}
        // Send user back to form, re-populate form with original form inputs,
        // and display the validation error messages to the user.
        // 
        return Redirect::back()->with_errors( $validation->errors )->with_input();
    }
        
    /**
     * Log the user out of their session.
     */
    public function get_logout()
    {       
        // Log user out of their session
        Auth::logout();
        
        // Redirect to application startpage
        return Redirect::to_route('home');
    }
}