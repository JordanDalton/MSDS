<?php

class Ajax_Controller extends Base_Controller {

	/**
	 * Search the MSDS database.
	 * 
	 * @return JSON
	 */
	public function get_search()
	{
		// Capture the input criteria
		// 
		$criteria = Input::query('criteria', function(){ return ''; });

		// Decode the criteria
		// 
		$criteria = urldecode( $criteria );

		// Search the MSDS database
		// 
		$search_results = Msds::where(function($where) use($criteria){
			$where->where('name', 		'like', "%{$criteria}%");
			$where->or_where('synonym', 'like', "%{$criteria}%");
			$where->where('active', '=', 1);
		})->get();

		// Return the results
		// 
		return Response::eloquent( $search_results );
	}

}