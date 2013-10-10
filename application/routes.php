<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

// {{ Application Homepage }}
Route::get('/', array('as' => 'home', 'uses' => 'msds@index'));

// {{ Authentication }}
Route::get( '/login',  array( 'as' => 'login',  'uses' => 'auth@login' ));
Route::post('/login',  array( 'uses' => 'auth@login' ));
Route::get( '/logout', array( 'as' => 'logout', 'uses' => 'auth@logout' ));

// {{ MIGRATION }}
Route::get('/migration/migrate', array('as' => 'migration.migrate', 'uses' => 'migration@migrate'));

// {{ MSDS }}
Route::get( '/msds/create', array( 'as' => 'msds.create', 'before' => 'auth|isAdmin', 'uses' => 'msds@create' ));
Route::post('/msds/create', array( 'before' => 'auth|isAdmin', 'uses' => 'msds@create' ));
Route::get( '/msds/edit/(:num)', array( 'as' => 'msds.edit', 'before' => 'auth|isAdmin', 'uses' => 'msds@edit' ));
Route::post('/msds/edit/(:num)', array( 'before' => 'auth|isAdmin', 'uses' => 'msds@edit' ));
Route::get( '/msds/active', 	 array( 'as' => 'msds.active', 'before' => 'auth|isAdmin', 'uses' => 'msds@active' ));
Route::get( '/msds/inactive', 	 array( 'as' => 'msds.inactive', 'before' => 'auth|isAdmin', 'uses' => 'msds@inactive' ));
Route::get('/msds/search', array( 'as' => 'msds.search', 'uses' => 'ajax@search' ));
Route::get('/msds/(:num)', array( 'as' => 'msds.show',   'uses' => 'msds@show' ));

// {{ PDFs }}
Route::get('/uploads/(:any)', array( 'as' => 'pdf.show' ));

/*
|--------------------------------------------------------------------------
| IoCs
|--------------------------------------------------------------------------
*/

require 'iocs.php';

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
*/

require('events.php');

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
*/

require('filters.php');

/*
|--------------------------------------------------------------------------
| View Composers
|--------------------------------------------------------------------------
*/

require 'composers.php';

/*
|--------------------------------------------------------------------------
| Macros
|--------------------------------------------------------------------------
*/

require 'macros.php';