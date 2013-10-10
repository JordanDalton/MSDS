<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| MSDS PDF Cutoff Date
	|--------------------------------------------------------------------------
	|
	| When PDFs are greater than 6 years old, they must be updated with a fresh
	| copy. The following will automatically generated the cutoff date.
	| and will auto increment each year.
	|
	*/
	'cutoff_date' => date('Y') - 6 . '-12-31'
);