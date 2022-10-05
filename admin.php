<?php
/*
	Copyright (c) 2017 - 2022 Daniel Burridge
*/
session_start();

define('IsPlymbb', TRUE);
require_once "config.php";

include "header.php";

// session variables
if(!array_key_exists('IsLoggedIn', $_SESSION) && empty($_SESSION['IsLoggedIn'])) {
	$_SESSION['IsLoggedIn'] = FALSE;
}

$action = $_GET['action'] ?? ''; // allows this page to not need the 'action' parameter for the URL
	
if($_SESSION["Rank"] < 1 || $_SESSION["IsLoggedIn"] == FALSE) { // if user is not an admin or is not logged in
	echo 'You must be logged in on an admin account to access this page.';
	header("Refresh: 1; URL=index.php");
	die();
}

if(!$action) {
?>
	<table class="table table-bordered">
		<tr>
			<th>Categories</th>
			<th>Settings</th>
		</tr>
		<tr>
			<td><a href="?action=createcategory" class="btn btn-warning btn-sm active" role="button" aria-pressed="true">Create Category</a></td>
			<td><a href="?action=settings" class="btn btn-warning btn-sm active" role="button" aria-pressed="true">Edit Site Settings</a></td>
		</tr>
	</table>
<?php
}
else if($action == "createcategory") {
	if($_SERVER['REQUEST_METHOD'] != 'POST') {
?>
		<form action="" method="post">
				<div class="form-group row">
					<label for="catname" class="col-sm-2 control-label">Category Name</label>
					<div class="col-sm-10">
						<input type="text" name="catname" class="form-control" id="catname" placeholder="Category Name">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="catdesc" class="col-sm-2 control-label">Description</label>
					<div class="col-sm-10">
						<input type="text" name="catdesc" class="form-control" id="catdesc" placeholder="Description">
					</div>
				</div>

				<div class="form-group row">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-success">Create</button>
					</div>
				</div>
			</form>
<?php
	}
	else {
		$esccatname = $sql_connection->real_escape_string(strip_tags($_POST['catname']));
		$esccatdesc = $sql_connection->real_escape_string(strip_tags($_POST['catdesc']));
		$result = $sql_connection->query("INSERT INTO categories(catname, description) VALUES('$esccatname', '$esccatdesc')");
		
		if(!$result) { // query failed
			echo 'Error: ' . mysqli_error($sql_connection);
		}
		else { // success!
			echo 'Category created successfully! Redirecting you back to the main page.';
			header("Refresh: 1; URL=index.php");
		}
	}
}
else if($action == "settings") {
	echo "Settings";
}

include "footer.php";
?>