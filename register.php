<?php
/*
	Copyright (c) 2017 - 2022 Daniel Burridge
*/
session_start();

define('IsPlymbb', TRUE);
require_once "config.php";

include "header.php";

if(!isset($_POST["username"])) { // if this is not set from the form on the account page then someone has tried to access this file directly.
	header("Refresh: 1; URL=index.php");
	die("An error occurred: Accessing this file directly is not permitted.");
}
 
if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
	$escname = $sql_connection->real_escape_string(strip_tags($_POST["username"]));
	$escpass = $sql_connection->real_escape_string(password_hash($_POST["password"], PASSWORD_DEFAULT));

	if(isset($escname)) {
		$result = $sql_connection->query("SELECT * FROM users where username='$escname'");
		
		if($result->num_rows >= 1) { // user exists
			echo "That username already exists in our database!";
			header("Refresh: 1; URL=index.php");
			die();
		}
		else { // user does not exist
			$escemail = $sql_connection->real_escape_string($_POST["email"]);
			$escdate = $sql_connection->real_escape_string(date('l jS \of F Y h:i:s A'));
		
			$sql = "INSERT INTO users(username, password, email, regdate) VALUES('$escname', '$escpass', '$escemail', '$escdate')";
			$result = $sql_connection->query($sql);
			
			$_SESSION["IsLoggedIn"] = TRUE;
			$_SESSION["Username"] = $escname;
			echo "You have registered successfully!";
			header("Refresh: 1; URL=index.php");
			die();
		}
	}
}
else {
	echo("That is not a valid email address.");
	header("Refresh: 1; URL=account.php?action=register");
	die();
}

include "footer.php";
?>