<?php
/*
	Copyright (c) 2017 - 2022 Daniel Burridge
*/
session_start();

define('IsPlymbb', TRUE);
require_once "config.php";

include "header.php";

if($_SESSION['IsLoggedIn'] == FALSE) {
	echo 'You are not logged in. To create a topic you must be logged in!';
	header("Refresh: 1; URL=index.php");
}
else {	// user is logged in
	if($_SERVER['REQUEST_METHOD'] != 'POST') {	
		$result = $sql_connection->query("SELECT topicid, posttext FROM posts WHERE postid='" .$_GET['pid'] . "'");
		
		if(!$result) {
			// the query failed
			echo "Error selecting from database: " . $sql_connection->error;
			die();
		}
		
		$row = $result->fetch_assoc();
?>
		<h2>Editing post in topic ID: <?php echo $row['topicid']; ?></h2>
		<form action="" method="post">
			<div class="form-group">
				<label for="postbody">Post Body:</label>
				<textarea class="form-control" rows="5" name="postbody"><?php echo $row['posttext']; ?></textarea>
			</div>

			<div class="form-group row">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-success">Edit</button>
				</div>
			</div>
		</form>
<?php
	}
	else {	
		$newtopictext = $sql_connection->real_escape_string($_POST['postbody']);
		$result = $sql_connection->query("UPDATE posts SET posttext='". $newtopictext ."' WHERE postid=". $_GET['pid']);

		if($result == TRUE) { // update was successfull
			echo 'Topic edited successfully! Redirecting you back to the topic.';
			header("Refresh: 1; URL=topic.php?id=" . $_GET['tid'] . "&bid=" . $_GET['bid']);
		} 
		else {
			echo "Error updating database: " . $sql_connection->error;
			die();
		}
	}
}
include "footer.php";
?>