<?php

abstract class My_File {

	/**
	 * Obtain the last modified date from a uploaded pdf file.
	 *
	 * @param  string $file_path The full path to the file.
	 * @return DateTime
	 */
	public static function getFileModifiedDate( $file_path = '' )
	{
		// The file does exist
		// 
		if( File::exists( $file_path ) )
		{
			// Get the time stamp (Unix) of when the file was last modified.
			// 
			$modified_timestamp = File::modified( $file_path );

			// Now we need to convert the timestamp to a DateTime format
			// 
			$date_time = new DateTime();
			$date_time->setTimestamp( $modified_timestamp );

			// Return the DateTime timestamps
			// 
			return $date_time->format( 'Y-m-d H:i:s' );
		}

		// Otherwise return nothing...
		// 
		return NULL;
	}

	/**
	 * Obtain the last modified date from a uploaded pdf file.
	 *
	 * @param  string $filename The pdf filename.
	 * @return DateTime
	 */
	public static function getPdfModifiedDate( $filename = '' )
	{
		// The full path to the pdf file
		// 
		$file_path = Config::get('upload.path') . DS . $filename;

		// The file does exist
		// 
		if( File::exists( $file_path ) )
		{
			// Get the time stamp (Unix) of when the file was last modified.
			// 
			$modified_timestamp = File::modified( $file_path );

			// Now we need to convert the timestamp to a DateTime
			// 
			$date_time = new DateTime();
			$date_time->setTimestamp( $modified_timestamp );

			// Return the DateTime timestamps
			// 
			return $date_time->format( 'Y-m-d H:i:s' );
		}

		// Otherwise return nothing...
		// 
		return NULL;
	}

	/**
	 * Check if a pdf exists in the uploads folder.
	 * 
	 * @param  string $file_name The name of the pdf file.
	 * @return Bool
	 */
	public static function pdfExists( $file_name = '' )
	{
		return File::exists( Config::get('upload.path') . DS . $file_name );
	}

	/**
	 * Check if a given date has surpassed our PDF cutoff date.
	 * @param  string  $date The current pdf_date_manual date.
	 * @return boolean       True = Outdated, False = Not-Outdated
	 */
	public static function isOutdated( $dateTime = '0000-00-00 00:00:00' )
	{
		// Fetch the pdf cutoff date from the config file
		// 
		$cutoff_date = Config::get('pdf.cutoff_date');

		// Convert the submitted dateTime and cutoff date to a
		// proper DateTime object
		// 
		$pdf_date_manual = new DateTime( $dateTime );
		$pdf_cutoff_date = new DateTime( $cutoff_date );

		// The submitted date is not outdatted.
		// 
		if( $pdf_date_manual > $pdf_cutoff_date )
		{
			// Return the date as not outdated.
			return false;
		}

		// By default, all pdfs are considered outdated.
		// 
		return TRUE;
	}
}