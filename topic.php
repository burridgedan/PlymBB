<?php
/*
	Copyright (c) 2017 - 2022 Daniel Burridge
*/
session_start();

define('IsPlymbb', TRUE);
require_once "config.php";

include "header.php";

if(!$_GET['id']) {
	echo '<p>An error occurred. Redirecting...</p>';
	header("Refresh: 1; URL=index.php");
	die();
}

if(!$_GET['bid']) {
	echo '<p>An error occurred. Redirecting...</p>';
	header("Refresh: 1; URL=index.php");
	die();
}

$id = $_GET['id'];
$bid = $_GET['bid'];

$result = $sql_connection->query("SELECT catid FROM topics WHERE topicid='$id'");

if($result->num_rows == 0) {
	echo 'This topic does not exist! Redirecting...';
	header("Refresh: 1; URL=index.php");
	die();
}

$row = $result->fetch_assoc();

if($row['catid'] != $bid) {
	echo 'ERROR: Invalid board ID for the topic. Redirecting...';
	header("Refresh: 1; URL=index.php");
	die();
}

$result = $sql_connection->query("SELECT * FROM topics WHERE topicid='$id'");

// prepare the table
echo '<table class="table table-bordered">
	  <tr>
		<th style="width:18%">User</th>
		<th>Post</th>
	  </tr>';
		  
while($row = $result->fetch_assoc()) {
	echo '<h1>' .$row['topicname']. '</h1>';

	echo '<tr>';
		echo '<td>';
			echo $row['postedby'];
		echo '</td>';
		
		echo '<td style="text-align:left">';
			echo '<b>' . $row['postedon'] . '</b>';
			echo '<hr />';
			echo $row['topictext'];
			if($_SESSION['Username'] == $row['postedby'] || $_SESSION["Rank"] == 1) { // if the post is by the user, or is an admin
				echo '<hr />';
				echo '<a href="edittopic.php?tid='. $row['topicid'] .'&bid=' . $bid . '" class="btn btn-info btn-sm active" role="button" aria-pressed="true">Edit</a>';
			}
		echo '</td>';
	echo '</tr>';
}
echo '</table>';

if($_SESSION["IsLoggedIn"] == TRUE) {
?>
	<a href="reply.php?tid=<?php echo $id; ?>&bid=<?php echo $bid; ?>" class="btn btn-success btn-lg active" role="button" aria-pressed="true">Reply</a>
<?php
	echo '<br /><br />';
}

// now for replies to the topic
$postresult = $sql_connection->query("SELECT * FROM posts WHERE topicid='$id'");
	
if($postresult->num_rows == 0) {
	// do nothing as there's no posts
}
else {
	// prepare the table
	echo '<table class="table table-bordered">
		  <tr>
			<th style="width:18%">User</th>
			<th>Post</th>
		  </tr>';
	echo '<h3>Replies</h3>'; 
	while($row = $postresult->fetch_assoc()) {		
		echo '<tr>';
			echo '<td>';
				echo $row['postedby'];
			echo '</td>';
			
			echo '<td style="text-align:left">';
				echo '<b>' . $row['postedon'] . '</b>';
				echo '<hr />';
				echo $row['posttext'];
				if($_SESSION['Username'] == $row['postedby'] || $_SESSION["Rank"] == 1) { // if the post is by the user, or is an admin
					echo '<hr />';
					echo '<a href="editpost.php?pid='. $row['postid'] .'&tid='. $row['topicid'] .'&bid='. $bid .'" class="btn btn-info btn-sm active" role="button" aria-pressed="true">Edit</a>';
				}
			echo '</td>';
		echo '</tr>';
	}
	echo '</table>';
}

include "footer.php";
?>