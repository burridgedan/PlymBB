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

if($_SESSION["IsLoggedIn"] == FALSE) {
	if(!$action) { // base page
	?>
		<a href="?action=login" class="btn btn-success btn-lg active" role="button" aria-pressed="true">Login</a>
        <a href="?action=register" class="btn btn-warning btn-lg active" role="button" aria-pressed="true">Register</a>
	<?php
	}
	else if($action == "login") {
		?>
			<br />
			<form action="login.php" method="post">
				<div class="form-group row">
					<label for="username" class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10">
						<input type="text" name="username" class="form-control" id="username" placeholder="Username">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="password" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
						<input type="password" name="password" class="form-control" id="password" placeholder="Password">
					</div>
				</div>

				<div class="form-group row">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-success">Login</button>
					</div>
				</div>
			</form>
			<?php
	}
	else if($action == "register") {
		?>
			<br />
			<form action="register.php" method="post">
				<div class="form-group row">
					<label for="username" class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10">
						<input type="text" name="username" class="form-control" id="username" placeholder="Username">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="password" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
						<input type="password" name="password" class="form-control" id="password" placeholder="Password">
					</div>
				</div>

				<div class="form-group row">
					<label for="email" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
						<input type="email" name="email" class="form-control" id="email" placeholder="Email">
					</div>
				</div>

				<div class="form-group row">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-success">Register</button>
					</div>
				</div>
			</form>
<?php
	}
	else if($action == "logout") {
		echo "An error occurred: You are not logged in!";
		header("Refresh: 1; URL=index.php");
		die();
	}
}
else { // user profile actions
	if(!$action) { // show user profile
?>
		<center><h1> <?php echo $_SESSION["Username"]; ?> </h1></center>
<?php
	}
	if($action == "logout") {
		if($_SESSION["IsLoggedIn"] == TRUE) {
			$_SESSION = array();
			session_destroy();
			echo "You have logged out!";
			header("Refresh: 1; URL=index.php");
			die();
		}
	}
}

include "footer.php";
?>