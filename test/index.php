<?php


ini_set( "error_log", "./php-error.log" );

require "../vendor/autoload.php";


$SC = new SourCream\SourCream;


$SC->start();


// $_SESSION["test"]["testing"] = "hello";

var_dump( $_SESSION );


unset( $_SESSION["test"]["testing"] );

