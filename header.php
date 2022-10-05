<?php
/*
	Copyright (c) 2017 - 2022 Daniel Burridge
*/
// sql connection
$sql_connection = new mysqli($sql_server, $sql_username, $sql_password, $sql_database);

// connection has failed so show error and kill the page
if($sql_connection->connect_error) {
    die('Connect Error (' . $sql_connection->connect_errno . ') ' . $sql_connection->connect_error);
}

// session variables
if(!array_key_exists('IsLoggedIn', $_SESSION) && empty($_SESSION['IsLoggedIn'])) {
	$_SESSION['IsLoggedIn'] = FALSE;
}

if(!array_key_exists('Username', $_SESSION) && empty($_SESSION['Username'])) {
	$_SESSION['Username'] = "";
}

if(!array_key_exists('Rank', $_SESSION) && empty($_SESSION['Rank'])) {
	$_SESSION['Rank'] = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PlymBB Forums</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<!-- TinyMCE Text Area -->
	<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=eq2xxy7iyktfd7l6q7b7o52tvppamuwzptdnm8kk7ekadcz5"></script>
	<script>
		tinymce.init({
			selector: 'textarea',
			height: 500,
			menubar: false,
			plugins: [
			'advlist autolink lists link image charmap print preview anchor textcolor',
			'searchreplace visualblocks code fullscreen',
			'insertdatetime media table contextmenu paste code help wordcount'
			],
			toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
			content_css: [
			'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			'//www.tinymce.com/css/codepen.min.css']
		});
	</script>
	
    <!-- Custom styles for this template -->
    <style>
		body {
			padding-top: 54px;
			background-color: #E2E6E8;
		}
		
		@media (min-width: 992px) {
			body {
			  padding-top: 56px;
			}
		}
		  
		.boardcontainer {
			border-radius: 20px;
			background-color: #FFFFFF;
			width: 70%;
			margin: auto;
			border: 1.5px solid black;
			padding: 10px;
		}
		
		.footer {
			border-radius: 20px;
			background-color: #FFFFFF;
			width: 70%;
			margin: auto;
			border: 1.5px solid black;
			padding: 10px;
		}
		
		.col-sm-offset-2 {
			margin: auto;
		}

		.col-sm-10 {
			width 95%;
		}
    </style>

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">PlymBB</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="account.php">Account</a>
			</li>
			<?php
			if($_SESSION['Rank'] == 1) {
			?>
			
			<li class="nav-item">
			  <a class="nav-link" href="admin.php">Admin Panel</a>
			</li>
			
			<?php }
			if($_SESSION["IsLoggedIn"] == FALSE) {
			?>
			<li class="nav-item">
			  <a href="account.php?action=login" class="btn btn-success btn-sm active" role="button" aria-pressed="true">Login</a>
			</li>
			
			<li class="nav-item">
			  <a href="account.php?action=register" class="btn btn-warning btn-sm active" role="button" aria-pressed="true">Register</a>
			</li>
			
			<?php }
			else { 
			?>
			<li class="nav-item">
			  <a href="account.php?action=logout" class="btn btn-danger btn-sm active" role="button" aria-pressed="true">Logout</a>
			</li>
			<?php } ?>
          </ul>
        </div>
      </div>
    </nav>
	<br />
    <!-- Page Content -->
    <div class="boardcontainer">
      <div class="row">
        <div class="col-lg-12 text-center">