<?php
$conn = mysqli_connect("localhost", "youthcyb_160s2g4", "oncourse2015", "youthcyb_cs160s2g4");
mysqli_set_charset($conn, "utf8");      
if (!$conn) {
	die("Database connection failed: " . mysqli_error());
} else {
	$db_select = mysqli_select_db($conn, "youthcyb_cs160s2g4");
	if (!$db_select) {
		//die("Database selection failed: " . mysqli_error($conn));
	}
}
?>
<head>
<?php
	session_unset();
	session_start();
 ?>
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

<?php include('socialmedia.php'); ?>

<nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a>
		</div>
		<div>
		  <ul class="nav navbar-nav">
			<li class="active"><a href="aboutus.php">About Us</a></li>
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

<style>
	.abouttable table, th, td {
		background-color: #DED5D5;
		text-align: left;
		border-collapse: collapse;
	}
	.abouttable td {
		border: none;
	}
	.image-cropper {
	  position: relative;
	  margin: left;
	  width: 180px;
	  height: 180px;
	  overflow: hidden;
	  border-style: dotted;
	  border-width: 2px;
	}
	.anthony {
	  position: absolute;
	  left: -20%;
	  top: -30%;
	}
	#anthony {
		background-color: #F0E6E6;
	}
	.byron {
	  position: absolute;
	  left: -25%;
	  top: -30%;
	}
	.andy {
	  position: absolute;
	  left: -30%;
	  top: -90%;
	}
	.ahmed {
	  position: absolute;
	  left: -30%;
	  top: -10%;
	}
	.kory {
	  position: absolute;
	  left: -65%;
	  top: -25%;
	}
	.matt {
	  position: absolute;
	  left: -20%;
	}
	span.glyphicon-th-list {
		font-size:1em;
	}
</style>

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
				xmlhttp.open("GET","register.php?fname="+ fname +"&lname="+ lname +"&user="+ username +"&pass="+ password +"&email="+ email,true);
				xmlhttp.send();
				
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

<br><!--start printing a table header containing all relevant fields' name-->
	<div class="container-fluid">
	<div class="g-hangout" data-render="createhangout"></div>
	<br />
	<br />
	<br />
    <table style="width:50%;white-space:nowrap;" align="center" class="footable footable-sortable table table-responsive" id="abouttable">
		<thead>
			<tr>
				<th colspan="6" style="font-size:2em;text-align:center;" colspan="3">OnCourse Team</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td rowspan="1"><div class="image-cropper"><img style="width:260;height:390;" class="anthony" src="imgs/anthony.jpg"></div></td>
				<td>
					<span style="font-size:1.25em;font-weight:bold;">Anthony Tsang</span>
				</td>
				<td rowspan="1"><div class="image-cropper"><img style="width:270;height:360;" class="byron" src="imgs/byron.jpg"></div></td>
				<td>
					<span style="font-size:1.25em;font-weight:bold;">Byron Custodio</span>
				</td>
				<td rowspan="1"><div class="image-cropper"><img style="width:290;height:360;" class="andy" src="imgs/andy.jpg"></div></td>
				<td>
					<span style="font-size:1.25em;font-weight:bold;">Andy Le</span>
				</td>
			</tr>
			<tr>
				<td rowspan="1"><div class="image-cropper"><img style="width:260;height:390;" class="ahmed" src="imgs/ahmed.jpg"></div></td>
				<td>
					<span style="font-size:1.25em;font-weight:bold;">Ahmed Syed</span>
				</td>
				<td rowspan="1"><div class="image-cropper"><img style="width:320;height:360;" class="kory" src="imgs/kory.jpg"></div></td>
				<td>
					<span style="font-size:1.25em;font-weight:bold;">Kory Le</span>
				</td>
				<td rowspan="1"><div class="image-cropper"><img style="width:290;height:360;" class="matt" src="imgs/matt.jpg"></div></td>
				<td>
					<span style="font-size:1.25em;font-weight:bold;">Matt Chi</span>
				</td>
			</tr>
		</tbody>
    </table>
	</div>
</br>
</body>
