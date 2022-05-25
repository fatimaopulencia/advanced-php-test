<?php
/**
 * Refactor this code to be the tidiest, 'best practice' design you can come up with
 * The point of this exercise is not to find minor bugs in the code, but to focus on the architecture of 
 * this piece of software and ensure it is very well designed - easy to maintain, extend, refactor over 
 * time as required.
 * 
 * This code uses a standalone implementation of Laravel Collections which provides the global 'collect'
 * method and various methods which operate on the resulting Collection object. 
 * https://laravel.com/docs/5.8/collections
 */

 use Illuminate\Support;

// prepare the request & process the arguments
$database = 'nba2019';
include('include/utils.php');
require_once('vendor/autoload.php');
require_once('classes/Controller.php');

// process the args
//comment: extracts the arguments passed through URL.
$args = collect($_REQUEST);

//comment: passed the argument to the controller function.
//this function handles the data extraction depending on the arguments passed by the user
$controller = new Controller($args);
echo $controller->export();   
