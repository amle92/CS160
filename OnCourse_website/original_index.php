<head>
<title>OnCourse</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>
<body>
<br>
	<nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="#">OnCourse</a>
		</div>
		<div>
		  <ul class="nav navbar-nav">
			<li><a href="#">Placeholder</a></li>
			<li><a href="#">Placeholder</a></li>
			<li><a href="#">Placeholder</a></li>
		  </ul>
		  <ul class="nav navbar-nav navbar-right">
			<li><a href="#"><span class="glyphicon glyphicon-user"></span> Register</a></li>
			<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
		  </ul>
		</div>
	  </div>
	</nav>
	<div class="container-fluid">
		<br />
		<br />
		<h1><p class="text-center">OnCourse</p></h1>
		<h3><p class="text-center">Your one-stop-shop of finding the courses that's right for you.</p></h3>
		<br />
		<br />
		<h2><p class="text-center">Search for a course:</p></h2>
		<div id="center_search">
			<form action="print_scraped_data2browser.php" method="get" class="form-inline">
				<div class="form-group">
				  <input type="text" class="form-control" name="searchstring" placeholder="Enter course">
				</div>
				<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
			</form>
		</div>
	</div>
	
	<div id="bg">
		!--Change this url to specified directory--!
		<img src="images/baseimg.jpg" alt="">
	</div>
</br>
</body>
