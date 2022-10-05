<?php
/*
	Copyright (c) 2017 - 2022 Daniel Burridge
*/
session_start();

define('IsPlymbb', TRUE);
require_once "config.php";

include "header.php";

if(!$_GET['id']) {
	echo '<p>An error occurred.</p>';
	header("Refresh: 1; URL=index.php");
}
else {
	$id = $_GET['id'];	

	$result = $sql_connection->query("SELECT * FROM categories WHERE catid=" . $id);
	
	if(!$result) {
		// the query failed
		echo "Error selecting from the database: " . $sql_connection->error;
		die();
	}
	
	if($result->num_rows == 0) {
		echo 'The board ID is invalid.';
		header("Refresh: 1; URL=index.php");
	}
	else {
		$row = $result->fetch_assoc();
		
		echo '<h2>' .$row['catname']. '</h2>';
		echo '<h3>' .$row['description']. '</h3>';
		
		if($_SESSION["IsLoggedIn"] == TRUE) {
		?>
			<a href="createtopic.php?cid=<?php echo $id; ?>" class="btn btn-success btn-lg active" role="button" aria-pressed="true">Create Topic</a>
		<?php
			echo '<br /><br />';
		}

		$result = $sql_connection->query("SELECT * FROM topics WHERE catid=" . $id . " ORDER BY topicid DESC");

		if($result->num_rows == 0) {
			echo 'No topics have been created yet.';
		}
		else {
			// prepare the table
				echo '<thead>
					  <table class="table table-bordered">
					  <tr>
						<th style="width:40%">Topic Title</th>
						<th style="width:10%">Replies</th>
						<th style="width:25%">Posted by</th>
						<th style="width:25%">Last Post By</th>
					  </tr>
					  </thead>';
			while($row = $result->fetch_assoc()) {	
				echo '<tbody>';
					echo '<tr>';
						echo '<td>';
							echo '<b><u><a href="topic.php?id=' . $row['topicid'] . '&bid=' . $row['catid'] .'">' . $row['topicname'] . '</a></u></b>';
						echo '</td>';
						
						$query = $sql_connection->query("SELECT * FROM posts WHERE topicid=" . $row['topicid']);
						$rows = $query->num_rows;
						
						echo '<td>';
							echo $rows;
						echo '</td>';
						
						echo '<td>';
							echo $row['postedby'];
						echo '</td>';
						
						echo '<td>';
							echo $row['lastposter'];
						echo '</td>';
					echo '</tr>';
				echo '</tbody>';
			}
			echo '</table>';
		}
	}
}

include "footer.php";
?>