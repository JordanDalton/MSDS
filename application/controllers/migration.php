<?php

class Migration_Controller extends Base_Controller {

	/**
	 * Execute the migration script.
	 * 
	 * @return Void
	 */
	public function get_migrate()
	{
		// Bail if we're not allowed to run the migration
		// 
		if( ! Config::get('migration.enabled') )
		{
			exit('You must enable migrations to proceed.');
		}

		// Fetch all msds records from the database
		// 
		$msds_records = MSDS::all();

		// Loop throughout the results set
		// 
		foreach( $msds_records as $msds_record )
		{
			// An original pdf file name exists
			// 
			if( (bool) $msds_record->pdf )
			{
				// File exists inside the directory
				// 
				if( My_File::pdfExists( $msds_record->pdf ) )
				{
					// Update the pdf_date with the legacy file's modified date timestamp
					// 
					$msds_record->pdf_date = My_File::getPdfModifiedDate( $msds_record->pdf );

					// The path to the original pdf file
					// 
					$original_path = Config::get('upload.path') . DS . $msds_record->pdf . '.pdf';

					// The new path (filename) that we want the file to be
					// 
					$new_path = Config::get('upload.path') . DS . $msds_record->id . '.pdf';

					// Now we attempt to change the name
					// 
					$update_filename = File::move( $original_path, $new_path );

					// Save the new pdf filename to the record
					// 
					$msds_record->pdf = $msds_record->id . '.pdf';

					// Save the changes to the record
					// 
					$msds_record->save();
				}
			}

			// Break out of the loop after the first record (testing purposes)
			// break;
		}

		exit('----------<h1>Migration Complete</h1>----------');
	}
}