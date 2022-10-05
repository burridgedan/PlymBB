<?php
/*
	Copyright (c) 2017 - 2022 Daniel Burridge
*/
session_start();

define('IsPlymbb', TRUE);
require_once "config.php";

include "header.php";

if($_SESSION['IsLoggedIn'] == FALSE) {
	echo 'You are not logged in. To reply to a topic you must be logged in! Redirecting...';
	header("Refresh: 1; URL=index.php");
}
else {	// user is logged in
	if($_SERVER['REQUEST_METHOD'] != 'POST') {

	$result = $sql_connection->query("SELECT * FROM topics WHERE topicid='" . $_GET['tid'] . "'");
	
	if(!$result) {
		header("Refresh: 1; URL=index.php");
		echo "Database Error: " . $sql_connection->error;
		die();
	}
	
	$row = $result->fetch_assoc();
?>
	<h2>Replying to topic: <?php echo $row['topicname']; ?></h2>
		<form action="" method="post">
		<div class="form-group">
			<label for="post_body">Post Body:</label>
			<textarea class="form-control" rows="5" name="post_body"></textarea>
		</div>

		<div class="form-group row">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-success">Post</button>
			</div>
		</div>
	</form>
<?php
	}
	else {
		$query = "INSERT INTO posts(topicid, postedby, posttext, postedon) VALUES(
		'" . $_GET['tid'] . "',
		'" . $sql_connection->real_escape_string($_SESSION['Username']) . "', 
		'" . $sql_connection->real_escape_string($_POST['post_body']) . "',
		'" . $sql_connection->real_escape_string(date('l jS \of F Y h:i:s A')) . "')";	
		$result = $sql_connection->query($query);
		
		$result = $sql_connection->query("UPDATE topics SET lastposter='" .$_SESSION['Username'] . "' WHERE topicid=" .$_GET['tid']); // update the topic entry for latest poster
		
		if(!$result) { // query failed
			header("Refresh: 1; URL=index.php");
			echo "Database Error: " . $sql_connection->error;
			die();
		}
		else { // success
			echo 'Topic posted successfully! Redirecting you back to the board.';
			header("Refresh: 1; URL=topic.php?id=" . $_GET['tid'] . "&bid=" .$_GET['bid']);
		}
	}
}
include "footer.php";
?>