<?php
session_start();
?>
<html>
<head>
<title>Register</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="index.php">OnCourse</a>
		</div>
		<div>
		  <ul class="nav navbar-nav">
			<li><a href="#">Placeholder</a></li>
			<li><a href="#">Placeholder</a></li>
			<li><a href="#">Placeholder</a></li>
		  </ul>
		  <ul class="nav navbar-nav navbar-right">
			<li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>
			<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
		  </ul>
		</div>
	  </div>
</nav>



<center>
    <form action="registerSubmit.php" method="POST" id="form">
		
    <br>    <br>
    <br>
    <br>

    First name:<br>
    <input type="text" name="fname" placeholder = "First Name" minlength = "1" maxlength = "20" autofocus required style='margin-top:5px'><br>

    Last name:<br>

    <input type="text" name="lname" placeholder = "Last Name" minlength = "1" maxlength = "20" required style='margin-top:5px'><br>

    Username:<br>

    <input type="text" name="username" placeholder = "UserName" minlength = "1" maxlength = "20" required style='margin-top:5px'><br>


    Password:<br>

    <input type="password" name="password" placeholder = "Password" minlength = "1" maxlength = "20" required style='margin-top:5px'><br>

	
    Email:<br>

    <input type="email" name="email" placeholder = "Your email" required style='margin-top:5px'><br>

<input type="submit" value="Submit" style='margin-top:15px'>
    </form>
</center>

</body>

</html>

