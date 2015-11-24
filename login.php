<html>
<head>
	<title>Login</title>
	<style type="text/css">
	#loginForm {
		margin-top:10%; 
		margin-left:10%;
	}
	input{
        margin-top:15px;
    }
    
	</style>
</head>

<body>
<title>Log In</title>
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
			<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
		  </ul>
		</div>
	  </div>
</nav>
<form id="loginForm"method='post' action="log-in.php">
	<table>
	<tr>
		<td>Username:&nbsp&nbsp&nbsp</td>
		<td><input type="text" name="userName" autofocus required/></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input type='password' name='password' required/></td>
	</tr>
	<tr>
		<td></td>
		<td><input type='Submit' name='Submit' value='Login'/>
		<input type='button' value='Register' onclick="location.href='register.php' " /></td>
	</tr>
	</table>
	</form>

</body>

</html>