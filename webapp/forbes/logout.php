<?php
// redirect user to another page
function redirect_user ($page) {
	// Start defining the URL...
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	$url = rtrim($url, '/\\');
	$url .= '/' . $page;
	// Redirect the user: 
	header("Location: $url"); exit(); // Quit the script.
}
// If cookie is present, delete the parameters:
if (isset($_COOKIE['email'])) {
	setcookie ('email', '');
	setcookie ('name', '');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <title> Log Out </title>
    </head>
	<body>
		<!-- Displays the main Page -->
		<div class="container-fluid">
			<div class="row content">
				<div class="main">
					<!-- Header -->
					<img src="head.jpg" alt="Allegheny Health Network">
					<h1 class="head">Forbes Regional Hospital <br/> CABG Expense Analyzer </h1><hr>
					<!-- Page Information -->
					<div class="panel panel-default" style="margin: 5em">
						<div class="panel-heading"> 
							<center><h5>Thank you for using the CABG Expense Analyzer. <br/><br/>
								You are now logged out!</h5></center>
						</div>	
					</div>
					<!-- Logout -->
					<center>					                   
						<a href="login.php" class="btn btn-info btn-lg">
							<span class="glyphicon glyphicon-log-in"></span> Login Again
						</a>
					</center>
				</div>
			</div>
		</div>
	</body>
</html>
