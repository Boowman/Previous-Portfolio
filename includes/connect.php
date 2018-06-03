<?php

/*
*	$host = "localhost";
*	$username = "admin";
*	$password = "";
*	$database = "";
*
*/
	$host = "localhost";
	$username = "deniszpo_boowman";
	$password = "lasvegas1";
	$database = "deniszpo_portfolio";

	$dbconnection = mysqli_connect($host,$username,$password,$database);
	$dbname = mysqli_select_db($dbconnection,$database);
	
	if(!$dbconnection)
	{
		echo "There was a problem connecting to the database.<br/>";
	}
	if(!$dbname)
	{
		echo "Database ".$database." doesn't exist.<br/>";
	}
?>