<?php
/*
	Copyright (c) 2017 - 2022 Daniel Burridge
*/
session_start();

define('IsPlymbb', TRUE);
require_once "config.php";

include "header.php";

$result = $sql_connection->query("SELECT * FROM categories");

if(!$result) { // an error occurred with the above query
	echo 'The categories could not be displayed due to an error, please try refreshing the page.';
	echo "Database Error: " . $sql_connection->error;
	die();
}

if($result->num_rows == 0) {
	echo 'No categories have been created yet.';
}
else {	
	// prepare the table
	echo '<table class="table table-bordered">
		  <tr>
			<th>Category</th>
			<th>Topics</th>
			<th>Latest Topic</th>
		  </tr>';
	while($row = $result->fetch_assoc()) {				
		echo '<tr>';
			echo '<td>';
				echo '<b><a href="category.php?id=' . $row['catid'] . '"><u>' . $row['catname'] . '</u></a></b><br />' . $row['description'];
			echo '</td>';
			
			$query = $sql_connection->query("SELECT * FROM topics WHERE catid=" . $row['catid']);
			$topiccount = $query->num_rows;
			
			echo '<td>';
				echo $topiccount;
			echo '</td>';
							
			$latesttopic = $sql_connection->query("SELECT topicid, topicname, postedby, lastposter, postedon, catid FROM topics WHERE catid='$row[catid]' ORDER BY topicid DESC LIMIT 1");
			echo '<td>';
			
			if(!$latesttopic) {
				echo 'Last topic could not be displayed.';
			}
			else {
				if($latesttopic->num_rows == 0) {
					echo 'There are no topics.';
				}
				else {
					while($lasttopic = $latesttopic->fetch_assoc()) {
						echo '<a href="topic.php?id=' . $lasttopic['topicid'] . '&bid=' . $lasttopic['catid'] .'">' . $lasttopic['topicname'] . '</a> <br /> ' . $lasttopic['postedon'] . '<br /> created by ' . $lasttopic['postedby'];
					}
				}
			}
			
			echo '</td>';
		echo '</tr>';
	}
	echo '</table>';
}

include "footer.php";
?>