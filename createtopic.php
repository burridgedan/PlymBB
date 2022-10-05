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
		$result = $sql_connection->query("SELECT catid, catname, description FROM categories");
		
		if(!$result) {
			header("Refresh: 1; URL=index.php");
			echo 'Error while selecting from database. Please try again later.';
		}
		else {
			$row = $result->fetch_assoc();
			
			if($result->num_rows == 0) {
				//there are no categories, so a topic can't be posted
				header("Refresh: 1; URL=index.php");
				echo 'Before you can post a topic, you must wait for an admin to create some categories.';
			}
			else {
?>
				<h2>Creating a topic in <?php echo $row['catname']; ?></h2>
				<form action="" method="post">
					<div class="form-group">
						<label for="topicname" class="col-sm-2 control-label">Topic Title:</label>
						<input type="text" name="topicname" class="form-control" id="topicname" placeholder="Topicname">
					</div>
					
					<div class="form-group">
						<label for="postbody">Post Body:</label>
						<textarea class="form-control" rows="5" name="postbody"></textarea>
					</div>

					<div class="form-group row">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-success">Post</button>
						</div>
					</div>
				</form>
<?php
			}
		}
	}
	else {
		$result = $sql_connection->query("SELECT catid, catname, description FROM categories");
		$row = $result->fetch_assoc();

		$query = "INSERT INTO topics(topicname, topictext, postedby, lastposter, postedon, catid, category) VALUES(
		'" . $sql_connection->real_escape_string(strip_tags($_POST['topicname'])) . "',
		'" . $sql_connection->real_escape_string($_POST['postbody']) . "', 
		'" . $sql_connection->real_escape_string($_SESSION['Username']) . "',
		'" . $sql_connection->real_escape_string($_SESSION['Username']) . "',
		'" . $sql_connection->real_escape_string(date('l jS \of F Y h:i:s A')) . "',
		'" .  $_GET['cid'] . "',
		'" . $sql_connection->real_escape_string($row['catname']) . "')";	
		$result = $sql_connection->query($query);
		
		if(!$result) { // query failed
			echo 'Error: ' . mysqli_error($sql_connection);
		}
		else { // success!
			$topicname = strip_tags($_POST['topicname']);
			$query = $sql_connection->query("SELECT topicid FROM topics WHERE topicname='$topicname'");
			$qresult = $query->fetch_assoc();
			
			echo 'Topic posted successfully! Directing you to the new topic.';
			header("Refresh: 1; URL=topic.php?id=" . $qresult['topicid'] . "&bid=" . $_GET['cid']);
		}
	}
}
include "footer.php";
?>