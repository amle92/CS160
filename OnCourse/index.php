<?php
/*change the credentials according to yours*/
require_once('dbconnect.php');
?>
<html>
<head>
<title>OnCourse</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
	
	<!-- Calls platform script for hangouts -->
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<link rel="stylesheet" type="text/css" href="stylesheet.css" />

	<!--- Meta properties for Facebook -->
	<meta property="og:url"           content="http://www.sjsu-cs.org/cs160/sec2group4/" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="OnCourse" />
    <meta property="og:description"   content="Your one stop journey to accelerate your mind." />
    <meta property="og:image"         content="" />
</head>
<body>

<?php include('socialmedia.php'); ?>

<br>
	<nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="index.php">Home</a>
		</div>
		<div>
		  <ul class="nav navbar-nav">
			<li><a href="#">About Us</a></li>
			<li><a href="print_scraped_data2browser.php">Courses</a></li>
			<li><a href="https://twitter.com/share" class="twitter-share-button" {count} data-url="http://www.sjsu-cs.org/cs160/sec2group4/" data-text="Check out all these amazing courses I found!">Tweet</a></li>
			<li><div class="fb-like" data-share="true" data-width="450" data-show-faces="true" data-colorscheme="dark"></div></li>
		  </ul>
		  <?php
			echo "
					<ul id='user_access' class='nav navbar-nav navbar-right'>
					<li><a id='login'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>
					<li><a id='register'><span class='glyphicon glyphicon-user'></span> Register</a></li>
					</ul>
				";
			?>
		</div>
	  </div>
	</nav>
	
	<?php
		$user_session = '';
		$pass_session = '';
	?>
	
	<div id="title" class="container-fluid">
		<h1><p class="text-center">OnCourse</p></h1>
		<h3><p class="text-center">Your one-stop-shop for finding the courses that's right for you.</p></h3>
		<br />
		<h2><p class="text-center">Search for a course</p></h2>
		<div id="center_search">
			<form action="print_scraped_data2browser.php" method="get" class="form-inline">
				<div class="form-group">
				  <input class="form-control input-lg" id="input" type="text" name="searchstring" placeholder="Enter course">
				</div>
				<br />
				<br />
				<button type="submit" id="searchbtn" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
			</form>
		</div>
	</div>
	
	<?php include('registration.php'); ?>
	
	<div id="bg">
		!--Change this url to specified directory--!
		<img src="imgs/baseimg.png" alt="">
		<img id="cover" src="imgs/backcover.png" alt="">
	</div>
	
</br>
</body>
</html>

<?php
	if (isset($_POST['username']) && $_POST['username'] != "") {
		$usernameToCheck = $_POST['username'];
		$passwordToCheck = $_POST['password'];
			
		$sql = $conn -> query("SELECT username, password FROM users"); 
				
		while ($row = mysqli_fetch_array($sql)) {
			if ($row['username'] == $usernameToCheck) {
				$user_session = $row['username'];
			}
			if ($row['password'] == $passwordToCheck) {
				$pass_session = $row['password'];
			}
		}
		if ($user_session == '') {
			echo "
				<script>
					$(document).ready(function() {
						$(function() {
							$('#error_username_log').show();
						});
					});
				</script>
			";
		}
		if ($pass_session == '') {
			echo "
				<script>
					$(document).ready(function() {
						$(function() {
							$('#error_password_log').show();
						});
					});
				</script>
			";
		}
		if ($user_session != '' && $pass_session != '') {
			echo "
				<script>
					var output = <?php echo $usernameToCheck; ?>;
					console.log( output );
				</script>
			";
		}
	}
	if (isset($_GET['user']) && isset($_GET['pass'])) {
		$fname = $_GET['fname'];
		$lname = $_GET['lname'];
		$username = $_GET['user'];
		$password = $_GET['pass'];
		$email = $_GET['email'];
		
		$insertsql = $conn -> query("INSERT INTO USERS (first_name, last_name, Username, Password, Email) VALUES ('$fname', '$lname', '$username', '$password', '$email')");
	}
?>