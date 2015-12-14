<html>
<head>
<?php session_start(); ?>
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

	<!--- Meta properties for Facebook -->
	<meta property="og:url"           content="http://www.sjsu-cs.org/cs160/sec2group4/" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="OnCourse" />
    <meta property="og:description"   content="Your one stop journey to accelerate your mind." />
    <meta property="og:image"         content="" />
</head>
<body>

<br>
	<nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a>
		</div>
		<div>
		  <ul class="nav navbar-nav">
			<li><a href="aboutus.php">About Us</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Courses
				<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="print_scraped_data2browser.php">All</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=canvas">Canvas</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=open2study">Open2Study</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=coursera">Coursera</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=edx">edX</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=novoed">NovoEd</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=udacity">Udacity</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=www.futurelearn.com">FutureLearn</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=iversity">Iversity</a></li>
				</ul>
			</li>
			<?php
				if(isset($_SESSION['username']))
				{
					echo "<li><a href='mycourses.php'>MyCourses</a></li>";
				}
			?>
			<li><a href="https://twitter.com/share" class="twitter-share-button" {count} data-url="http://www.sjsu-cs.org/cs160/sec2group4/" data-text="Check out all these amazing courses I found!">Tweet</a></li>
			<li><div class="fb-like" data-share="true" data-width="450" data-show-faces="true" data-colorscheme="dark"></div></li>
		  </ul>
		  <?php
		  if(isset($_SESSION['username'])){
  			echo "
  					<ul id='user_access' class='nav navbar-nav navbar-right'>
					<li><a href='mycourses.php'><span class='glyphicon glyphicon-user'></span> ".$_SESSION['username']."</a></li>
  					<li><a href='logout.php' class='logout'><span class='glyphicon glyphicon-log-out'></span> LogOut</a></li>
  					</ul>
  				";
		  }
		  else{
			echo "
					<ul id='user_access' class='nav navbar-nav navbar-right'>
					<li><a id='login'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>
					<li><a id='register'><span class='glyphicon glyphicon-user'></span> Register</a></li>
					</ul>
				";}
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
	
	<?php include('navbar_panels.php'); ?>
	
	<script>
		var nameValid = /^[A-Za-z]+$/;
		var emailValid = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		var passValid = /^[a-z0-9]+$/i;
		
		function login_user(username, password) {
			$("#error_log").hide();
				
			var username = $("#username_log").val();
			var password = $("#password_log").val();
			if (username == "") {
				username = "null";
			}
			if (password == "") {
				password = "null";
			}

			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					var result = xmlhttp.responseText;
					console.log(result);					
					if (result == "success") {
						$("#error_log").slideUp();
						location.reload();
					}
					else {
						$("#error_log").slideDown();
						document.getElementById("error_log").innerHTML = xmlhttp.responseText;
					}
				}
			};
			xmlhttp.open("GET","login.php?user="+username+"&pass="+password,true);
			xmlhttp.send();
		}
		
		function register_user(fname, lname, username, password, email) {
			$(document).ready(function() {
				$("#error_fname").slideUp();
				$("#error_lname").slideUp();
				$("#error_username").slideUp();
				$("#error_password").slideUp();
				$("#error_email").slideUp();
				
				var fname = $("#fname").val();
				var lname = $("#lname").val();
				var username = $("#username").val();
				var password = $("#password").val();
				var email = $("#email").val();
				if (!nameValid.test(fname) || fname === '') {
					$("#error_fname").slideDown();
				}
				else if (!nameValid.test(lname) || lname === '') {
					$("#error_lname").slideDown();
				}
				else if (username.length < 5) {
					$("#error_username").slideDown();
				}
				else if (!passValid.test(password) || password.length < 5) {
					$("#error_password").slideDown();
				}
				else if (!emailValid.test(email) || email === '') {
					$("#error_email").slideDown();
				}
				else {		
					if (window.XMLHttpRequest) {
						xmlhttp = new XMLHttpRequest();
					} else {
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					console.log("test1");
					xmlhttp.open("GET","register.php?fname="+ fname +"&lname="+ lname +"&user="+ username +"&pass="+ password +"&email="+ email,true);
					xmlhttp.send();
					console.log("test2");
					
					$("#register_close").dialog({
						autoOpen: true,
						resizable: false,
						draggable: false,
						width: 300,
						height: 200,
						dialogClass: 'no-close register_menu-dialog'
					});
				}
			});
		}
	</script>
	
	<div id="bg">
		!--Change this url to specified directory--!
		<img src="imgs/baseimg.png" alt="">
		<img id="cover" src="imgs/backcover.png" alt="">
	</div>
	
</br>
</body>
</html>