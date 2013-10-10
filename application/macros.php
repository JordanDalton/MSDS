<?php

/*
|--------------------------------------------------------------------------
| Custom Macros
|--------------------------------------------------------------------------
|
| It's easy to define your own custom HTML class helpers called "macros". Here's how it works. First, simply register the macro with a given name and a Closure:
| Registering a HTML macro:
| 
| HTML::macro('my_element', function()
| {
|     return '<article type="awesome">';
| });
| 
| Now you can call your macro using its name:
| Calling a custom HTML macro:
| 
| echo HTML::my_element();
|
*/

HTML::macro('default_layout', function(){
	return Config::get('layout.default');
});