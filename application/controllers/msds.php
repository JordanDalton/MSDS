<?php

class Msds_Controller extends Base_Controller {

	/**
	 * Display MSDS in tabular form.
	 * 
	 * @return View
	 */
	public function get_index()
	{
		// Fetch the criteria from the query string (Defaults to false if no criteria was set)
		// 
		$criteria = Input::query( 'criteria' , function(){ return FALSE; } );

		// Fetch MSDS records from the database
		// 
		$msds_records = MSDS::where( function( $where ) use( $criteria ) {
			
			// Only show active records if user is not a logged in administrator
			// 
			if( ! Auth::check() )
			{
				$where->where('active', '=', 1);
			}

			// Filter results if criteria is set
			// 
			if( $criteria )
			{
				// Decode the criteria
				// 
				$criteria = urldecode( $criteria );

				// Filter the results
				// 
				$where->where('name', 		  	 'like', '%' . $criteria . '%');
				$where->or_where('synonym', 	 'like', '%' . $criteria . '%');
				$where->or_where('manufacturer', 'like', '%' . $criteria . '%');
			}
		})->paginate();

		// Set appendages to the query string
		// 
		$msds_records->appends(array(
			'criteria' => $criteria ? $criteria : array()
		));

		// Show the page
		// 
		return View::make( 'msds.index' )
				   ->with( 'msds_records' , $msds_records )
				   ->nest( 'form' , 'msds.index.form' );
	}

	/**
	 * MSDS record creation form
	 * 
	 * @return View
	 */
	public function get_create()
	{
		// Show the page
		// 
		return View::make( 'msds.create' )->nest( 'form', 'msds.create.form' );
	}

	/**
	 * Process MSDS record creation form
	 *
	 * @return Redirect
	 */
	public function post_create()
	{	
		// Define the validaiton rules
		// 
		$rules = array(
			'active'					=> 'required|integer|min:0|max:1',
			'hmis_flammability'			=> 'required|integer|min:0|max:4',
			'hmis_health'				=> 'required|integer|min:0|max:4',
			'hmis_personal_protection'	=> 'required|integer|min:0|max:4',
			'hmis_physical_hazard'		=> 'required|integer|min:0|max:4',
			'hmis_research_pending'		=> 'integer|min:0|max:1',
			'manufacturer' 				=> 'required|min:2',
			'name' 						=> 'required|min:2',
			'pdf'						=> 'mimes:pdf',
			'pdf_date_manual'			=> 'match:/^\d{4}\-\d{2}\-\d{2}$/',
			'synonym' 					=> 'required|min:2',
		);

		// Create an array of custom messages for the Validator
		// 
		$messages = array(
			'pdf_mimes' 	  		=> 'The uploaded file must be a file of type: :values.',
			'pdf_date_manual_match' => 'The PDF date must be in the format yyyy-mm-dd.'
		);

		// Create a Validator instance and validate the data
		// 
		$validation = Validator::make( Input::all() , $rules , $messages );

        // {{ Passed Validation }}
        // 
        if( $validation->passes() )
        {
        	// Create MSDS instance
        	// 
        	$msds_record = new MSDS( Input::except( 'csrf_token', 'pdf' ) );

        	// Save the record into the database
        	// 
        	$msds_record->save();

        	// File was submitted through the form
        	// 
        	if( (bool) Input::file('pdf.name') )
        	{
        		// Move the file to a permanent location
        		// 
        		Input::upload( 'pdf' , Config::get( 'upload.path' ), $msds_record->id . '.pdf' );

        		// Save the pdf data to the database record
        		// 
        		$msds_record->pdf 	   = $msds_record->id . '.pdf';
				$msds_record->pdf_date = My_File::getPdfModifiedDate( $msds_record->pdf );
				$msds_record->save();
        	}

        	// Redirect user back to the form, along with a message that tells them
        	// that the new MSDS record was successfully created.
        	// 
        	return Redirect::back()->with( 'success' , 'MSDS record was successfully generated.' );
    	}

        // {{ Failed Authentication}}
        // Send user back to form, re-populate form with original form inputs,
        // and display the validation error messages to the user.
        // 
        return Redirect::back()->with_errors( $validation->errors )->with_input();
	}

	/**
	 * Edit and existing msds record.
	 * 
	 * @param  integer $id The identification number of the MSDS record.
	 * @return View
	 */
	public function get_edit( $id = 0 )
	{
		// Fetch the msds record from the database
		// 
		$msds_record = MSDS::find( $id );

		// Bail if the record does not exist
		// 
		if( is_null( $msds_record ) ) 
		{
			// Redirect user back to the homepage, where they will be displayed a error message.
			// 
			return Redirect::to_route( 'home' )->with( 'error' , 'Unable to located the requested MSDS record.' );
		}

		// Show the page
		// 
		return View::make( 'msds.edit' )
				   ->with( 'msds_record' , $msds_record )
				   ->nest( 'form' , 'msds.edit.form', array( 'msds_record' => $msds_record ) );
	}

	/**
	 * Update an existing MSDS record.
	 * 
	 * @param  integer $id The identification number of the MSDS record.
	 * @return View
	 */
	public function post_edit( $id = 0 )
	{
		// Fetch the msds record from the database
		// 
		$msds_record = MSDS::find( $id );

		// Bail if the record does not exist
		// 
		if( is_null( $msds_record ) )
		{
			// Redirect user back to the homepage, where they will be displayed a error message.
			// 
			return Redirect::to_route( 'home' )->with( 'error' , 'Unable to located the requested MSDS record.' );
		} 

		// Define the validaiton rules
		// 
		$rules = array(
			'active'					=> 'required|integer|min:0|max:1',
			'hmis_flammability'			=> 'required|integer|min:0|max:4',
			'hmis_health'				=> 'required|integer|min:0|max:4',
			'hmis_personal_protection'	=> 'required|integer|min:0|max:4',
			'hmis_physical_hazard'		=> 'required|integer|min:0|max:4',
			'hmis_research_pending'		=> 'integer|min:0|max:1',
			'manufacturer' 				=> 'required|min:2',
			'name' 						=> 'required|min:2',
			'pdf'						=> 'mimes:pdf',
			'pdf_date_manual'			=> 'match:/^\d{4}\-\d{2}\-\d{2}$/|after:' . Config::get('pdf.cutoff_date'),
			'synonym' 					=> 'required|min:2',
		);

		// Create an array of custom messages for the Validator
		// 
		$messages = array(
			'pdf_date_manual_match' => 'The PDF date must be in the format yyyy-mm-dd.',
			'pdf_date_manual_after' => '"The PDF date must be a date after :date.'
		);

		// Create a Validator instance and validate the data
		// 
		$validation = Validator::make( Input::all() , $rules , $messages );

        // {{ Passed Validation }}
        // 
        if( $validation->passes() )
        {
        	// Assigned the updated data to the appropriate fields
        	// 
			$msds_record->fill( Input::except( 'csrf_token', 'pdf' ) );

        	// Save the changes to the record
        	// 
        	$msds_record->save();

       		// File was submitted through the form
        	// 
        	if( (bool) Input::file('pdf.name') )
        	{
        		// The full path to the pdf file
        		// 
        		$file_path = Config::get( 'upload.path' ) . DS . $msds_record->pdf;

        		// If a pdf file already exists, we will first need to remove
        		// the existing one before the new one can be uploaded.
        		// 
        		if( File::exists( $file_path ) )
        		{
        			// Remove the file from the pdf directory
        			// 
        			File::delete( $file_path );
        		}

        		// Move the file to the permanent pdf uploads location
        		// 
        		Input::upload( 'pdf' , Config::get( 'upload.path' ), $msds_record->pdf );

        		// Save the pdf data to the database record
        		// 
        		$msds_record->pdf      = $msds_record->id . '.pdf';
			$msds_record->pdf_date = My_File::getPdfModifiedDate( $msds_record->pdf );
			$msds_record->save();
        	}

        	// Redirect back to the edit form with successfull update message.
        	// 
        	return Redirect::back()->with( 'success' , 'MSDS record was successfully updated.' );
        }

        // {{ Failed Authentication}}
        // Send user back to form, re-populate form with original form inputs,
        // and display the validation error messages to the user.
        // 
        return Redirect::back()->with_errors( $validation->errors )->with_input();
	}

	// 

	/**
	 * Generate Master Chemical Spreadsheet List/Report for Inactive MSDS'
	 * 
	 * @return Excel
	 */
	public function get_inactive()
	{
		// Set the order and column aliases the array needs to be in 
		// as requested by Ken Reasoner on 3/19/2013
		// 
		$header_alias = array(
			'name as '						. Str::slug('Product Name', '_'),
			'manufacturer as '				. Str::slug('Manufacturer', '_'),
			'synonym as '					. Str::slug('Synonym', '_'),
			'hmis_health as '				. Str::slug('HMIS - Health', '_'),
			'hmis_flammability as '			. Str::slug('HMIS - Flammability', '_'),
			'hmis_physical_hazard as '		. Str::slug('HMIS - Physical Hazard', '_'),
			'hmis_personal_protection as '	. Str::slug('HMIS - PPE', '_'),
			'pdf_date as '					. Str::slug('MSDS Date', '_'),
			'active as '					. Str::slug('Active Chemical', '_'),
			'pdf_date_manual as '			. Str::slug('PDF Date Manual', '_'),
			'pdf as '						. Str::slug('PDF ID', '_'),
			'created_at as '				. Str::slug('Created At', '_'),
			'updated_at as '				. Str::slug('Updated At', '_'),
		);

		// Query for all active msds records from the database
		// 
		$inactive_records = MSDS::where_active( false )->get( $header_alias );

		// Query for all active records
		// 
		$msds_records = array_map(function($record){
			return $record->to_array();
		}, $inactive_records);

		// Set the filename for the csv we'll be generating
		// 
		$file_name = 'Master_Chemical_List_Inactive_' . time() . '.csv';

		// Set the path to the csv file
		// 
		$file_path = Config::get('report.path') . DS . $file_name;

		// Create a new .csv file
		// 
		$fp = fopen( $file_path , 'w' );

		// An array where all the table headings will be assigned to.
		// 
		$table_headers = array();

		// Loop through the very first record. This will allow us to properly
		// set the columns headings on the .csv
		// 
		foreach($msds_records[0] as $key => $value)
		{
			// Take all columns name, capitalize them, then strip out
			// any underscores
			// 
			$modify = preg_replace('/(\_)/', ' ', Str::upper($key));

			// If the columns is a HMIS related-column, we neeed to add
			// a hypen to the name
			// 
			$modify = preg_replace('/^(HMIS\s)/', ' $1- ', $modify);

			// Now we offically set the column heading
			// 
			$table_headers[] = $modify;
		}

		// Add the table headers to the .csv
		// 
		fputcsv( $fp , $table_headers );

		// Loop through all the records
		// 
		foreach( $msds_records as $record )
		{
			// Show pdf file as null if it does not match
			// our defined pdf format [id_number].pdf
			// 
			if( ! preg_match('/^\d+\.pdf/', $record['pdf_id']) )
			{
				$record['pdf_id'] = null;
			}

			// Append the record to the csv.
			// 
		    fputcsv( $fp , $record );
		}
	
		// All data has been applied, close the file.
		// 
		fclose($fp);

		// Now download the file
		// 
		return Response::download( $file_path );
	}


	/**
	 * Generate Master Chemical Spreadsheet List/Report for for all actiive MSDS'
	 * 
	 * @return Excel
	 */
	public function get_active()
	{
		// Set the order and column aliases the array needs to be in 
		// as requested by Ken Reasoner on 3/19/2013
		// 
		$header_alias = array(
			'name as '						. Str::slug('Product Name', '_'),
			'manufacturer as '				. Str::slug('Manufacturer', '_'),
			'synonym as '					. Str::slug('Synonym', '_'),
			'hmis_health as '				. Str::slug('HMIS - Health', '_'),
			'hmis_flammability as '			. Str::slug('HMIS - Flammability', '_'),
			'hmis_physical_hazard as '		. Str::slug('HMIS - Physical Hazard', '_'),
			'hmis_personal_protection as '	. Str::slug('HMIS - PPE', '_'),
			'pdf_date as '					. Str::slug('MSDS Date', '_'),
			'active as '					. Str::slug('Active Chemical', '_'),
			'pdf_date_manual as '			. Str::slug('PDF Date Manual', '_'),
			'pdf as '						. Str::slug('PDF ID', '_'),
			'created_at as '				. Str::slug('Created At', '_'),
			'updated_at as '				. Str::slug('Updated At', '_'),
		);

		// Query for all active msds records from the database
		// 
		$active_records = MSDS::where_active( true )->get( $header_alias );

		// Query for all active records
		// 
		$msds_records = array_map(function($record){
			return $record->to_array();
		}, $active_records);

		// Set the filename for the csv we'll be generating
		// 
		$file_name = 'Master_Chemical_List_Active_' . time() . '.csv';

		// Set the path to the csv file
		// 
		$file_path = Config::get('report.path') . DS . $file_name;

		// Create a new .csv file
		// 
		$fp = fopen( $file_path , 'w' );

		// An array where all the table headings will be assigned to.
		// 
		$table_headers = array();

		// Loop through the very first record. This will allow us to properly
		// set the columns headings on the .csv
		// 
		foreach( $msds_records[0] as $key => $value )
		{
			// Take all columns name, capitalize them, then strip out
			// any underscores
			// 
			$modify = preg_replace('/(\_)/', ' ', Str::upper($key));

			// If the columns is a HMIS related-column, we neeed to add
			// a hypen to the name
			// 
			$modify = preg_replace('/^(HMIS\s)/', ' $1- ', $modify);

			// Now we offically set the column heading
			// 
			$table_headers[] = $modify;
		}

		// Add the table headers to the .csv
		// 
		fputcsv( $fp , $table_headers );

		// Loop through all the records
		// 
		foreach( $msds_records as $record )
		{
			// Show pdf file as null if it does not match
			// our defined pdf format [id_number].pdf
			// 
			if( ! preg_match( '/^\d+\.pdf/', $record['pdf_id'] ) )
			{
				$record['pdf_id'] = null;
			}

			// Append the record to the csv.
			// 
		    fputcsv( $fp , $record );
		}
	
		// All data has been applied, close the file.
		// 
		fclose($fp);

		// Now download the file
		// 
		return Response::download( $file_path );
	}

	/**
	 * View MSDS Record
	 * 
	 * @param  integer $id The identification number of the MSDS record.
	 * @return View
	 */
	public function get_show( $id = 0 )
	{
		// Fetch the msds record from the database
		// 
		$msds_record = MSDS::find( $id );

		// Conditions for which a 404 error may be generated.
		// 
		switch( true )
		{
			// Condition #1 : The MSDS record does not exists
			// 
			case is_null( $msds_record ):

				// Redirect user back to the homepage, where they will be displayed a error message.
				// 
				return Redirect::to_route( 'home' )->with( 'error' , 'Unable to located the requested MSDS record.' );

			break; // End Condition #1

			// Condition #2 : No PDF record is specified
			// 
			case is_null( $msds_record->pdf ):

				// Redirect user back to the homepage, where they will be displayed a error message.
				// 
				return Redirect::to_route( 'home' )->with( 'error' , 'The PDF you\'re attempting to view cannot be located.' );

			break; // End Condition #2
		}

		// Show the page
		// 
		return View::make( 'msds.show' )->with( 'msds_record' , $msds_record );
	}
}
