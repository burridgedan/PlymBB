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

$escname = $sql_connection->real_escape_string(strip_tags($_POST["username"]));
$escpass = $sql_connection->real_escape_string(password_hash($_POST["password"], PASSWORD_DEFAULT));

if(isset($escname)) {
	$result = $sql_connection->query("SELECT * FROM users where username='$escname'");
	$row = $result->fetch_assoc();
	
	if($result->num_rows >= 1) { // user exists
		if(password_verify($_POST["password"], $row['password'])) { // if password matches
			$_SESSION["IsLoggedIn"] = TRUE;
			$_SESSION["Username"] = $escname;
			$_SESSION["Rank"] = $row['rank'];
			echo '<p>Hello ' . $_SESSION["Username"] . '</p><p>You have logged in successfully!</p>';
			header("Refresh: 1; URL=index.php");
		}
		else { // it does not match!
			echo'The password is incorrect!';
			header("Refresh: 1; URL=account.php?action=login");
			die();
		}
	}
	else { // user does not exist
		echo'The username you entered does not exist in our database!';
		header("Refresh: 1; URL=account.php?action=register");
		die();
	}
}

include "footer.php";
?>