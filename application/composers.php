<?php

View::composer('layouts.default', function($view){
	$view->nest('header', 'layouts.default.header');
});