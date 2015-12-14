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
			<li><a href="aboutus.php">About Us</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Courses
				<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li class="active"><a href="print_scraped_data2browser.php">All</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=canvas">Canvas</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=open2study">Open2Study</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=coursera">Coursera</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=edx">edX</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=novoed">NovoEd</a></li>
					<li><a href="print_scraped_data2browser.php?course_type=Udacity">Udacity</a></li>
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
	include('navbar_panels.php'); 
	function getResult($c, $t) {
		echo "<h1 style='text-align:center;'>Found " . $c . " Courses</h1>";
		$siteToMatch = strpos($_GET['course_type'], "futurelearn");
		if ($siteToMatch === false) {
			echo "<p style='text-align:center;font-size:1.5em;'>Search criteria: '" . $t . "'</p>";
		}
		else {
			echo "<p style='text-align:center;font-size:1.5em;'>Search criteria: futurelearn</p>";
		}
		echo "<br />";
		echo "<br />";
	}
?>

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

<script>	
	function addCourse(course_id) {
		$('.btn').on('click', function() {
			$(this).fadeOut("fast", function() {
				$(this).replaceWith("<button class='btn btn-primary disabled'><span class='glyphicon glyphicon-ok'></span> Already added!</button>");
			});
		});
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var temp = <?php echo json_encode($_SESSION['userid']);?>;
		console.log(temp);
		xmlhttp.open("GET","addcourse.php?userid="+temp+"&courseid="+course_id,true);
		xmlhttp.send();
	}
</script>

<br><!--start printing a table header containing all relevant fields' name-->
	<div class="container-fluid">
	<div class="g-hangout" data-render="createhangout"></div>
	<br />
	<br />
	<br />
    <table class="footable footable-sortable table" id="coursetable">
        <thead>
			<tr>
            <!--<th data-sort-ignore="true">Course Image</th>-->
            <!--<th data-sort-ignore="true">Course Name</th>-->
			<!--<th data-sort-ignore="true">Professor Name</th>-->
			<!--<th data-sort-ignore="true">Professor Image</th>-->
            <!--<th data-sort-ignore="true">Short Description</th>-->
			<!--<th data-sort-ignore="true">Video Link</th>-->
            <!--<th data-sort-ignore="true">Category</th>-->
            <!--<th data-sort-ignore="true">Start Date</th>-->
            <!--<th data-sort-ignore="true">Course Length(Days)</th>-->
            <!--<th data-sort-ignore="true">Site</th>-->
            <!--more here-->
			</tr>
        </thead>
		<tbody>
		<?php
			if (isset($_GET['course_type'])) {
				$type = $_GET['course_type'];
				$result = $conn->query("SELECT course_data.id, course_data.title,
                                               course_data.short_desc, course_data.course_link, 
											   course_data.start_date, course_data.course_length, 
											   course_data.course_image, course_data.category, course_data.site,
                                               GROUP_CONCAT(coursedetails.profname) as profname,
                                               GROUP_CONCAT(coursedetails.profimage) as profimage, coursedetails.course_id
										FROM course_data, coursedetails 
										WHERE course_data.id = coursedetails.course_id AND course_data.site = '$type'
										GROUP BY coursedetails.course_id
										ORDER BY course_data.title ASC");
			}
			else if (isset($_GET['searchstring'])) {
				$type = $_GET['searchstring'];
				$result = $conn->query("SELECT course_data.id, course_data.title,
                                               course_data.short_desc, course_data.course_link, 
											   course_data.start_date, course_data.course_length, 
											   course_data.course_image, course_data.category, course_data.site,
                                               GROUP_CONCAT(coursedetails.profname) as profname,
                                               GROUP_CONCAT(coursedetails.profimage) as profimage, coursedetails.course_id
										FROM course_data, coursedetails 
										WHERE course_data.id = coursedetails.course_id AND course_data.title LIKE '%$type%'
										GROUP BY coursedetails.course_id
										ORDER BY course_data.title ASC");
			}
			else {
				$result = $conn->query("SELECT course_data.id, course_data.title,
                                               course_data.short_desc, course_data.course_link, 
											   course_data.start_date, course_data.course_length, 
											   course_data.course_image, course_data.category, course_data.site,
                                               GROUP_CONCAT(coursedetails.profname) as profname,
                                               GROUP_CONCAT(coursedetails.profimage) as profimage, coursedetails.course_id
										FROM course_data, coursedetails 
										WHERE course_data.id = coursedetails.course_id
										GROUP BY coursedetails.course_id
										ORDER BY course_data.title ASC");
			}
			if(isset($_GET['searchstring'])) {
				$usersearch = $_GET['searchstring'];
			}
			
			$numrows = mysqli_num_rows($result);
			$count = $numrows;
			$rowsperpage = 10;
			$totalpages = ceil($numrows / $rowsperpage);
			if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
				$currentpage = (int) $_GET['currentpage'];
			} 
			else {
				$currentpage = 1;
			}
			if ($currentpage > $totalpages) {
				$currentpage = $totalpages;
			}
			if ($currentpage < 1) {
				$currentpage = 1;
			}
			$offset = ($currentpage - 1) * $rowsperpage;
			$variable = ($offset + $rowsperpage) - 1;
			
			if (isset($_GET['course_type'])) {
				$type = $_GET['course_type'];
				$result = $conn->query("SELECT course_data.id, course_data.title,
                                               course_data.short_desc, course_data.course_link, 
											   course_data.start_date, course_data.course_length, 
											   course_data.course_image, course_data.category, course_data.site,
                                               GROUP_CONCAT(coursedetails.profname) as profname,
                                               GROUP_CONCAT(coursedetails.profimage) as profimage, coursedetails.course_id
										FROM course_data, coursedetails 
										WHERE course_data.id = coursedetails.course_id AND course_data.site = '$type'
										GROUP BY coursedetails.course_id
										ORDER BY course_data.title ASC
										LIMIT $offset,$rowsperpage");
			}
			else if (isset($_GET['searchstring'])) {
				$type = $_GET['searchstring'];
				$result = $conn->query("SELECT course_data.id, course_data.title,
                                               course_data.short_desc, course_data.course_link, 
											   course_data.start_date, course_data.course_length, 
											   course_data.course_image, course_data.category, course_data.site,
                                               GROUP_CONCAT(coursedetails.profname) as profname,
                                               GROUP_CONCAT(coursedetails.profimage) as profimage, coursedetails.course_id
										FROM course_data, coursedetails 
										WHERE course_data.id = coursedetails.course_id AND course_data.title LIKE '%$type%'
										GROUP BY coursedetails.course_id
										ORDER BY course_data.title ASC
										LIMIT $offset,$rowsperpage");
			}
			else {
				$result = $conn->query("SELECT course_data.id, course_data.title,
                                               course_data.short_desc, course_data.course_link, 
											   course_data.start_date, course_data.course_length, 
											   course_data.course_image, course_data.category, course_data.site,
                                               GROUP_CONCAT(coursedetails.profname) as profname,
                                               GROUP_CONCAT(coursedetails.profimage) as profimage, coursedetails.course_id
										FROM course_data, coursedetails 
										WHERE course_data.id = coursedetails.course_id
										GROUP BY coursedetails.course_id
										ORDER BY course_data.title ASC
										LIMIT $offset,$rowsperpage");
			}
			
			if($result)
			{				
				while($row = $result->fetch_assoc())
				{				
					$image = explode(",", $row['profimage']);
					$counter = 0;
					echo "<script>console.log(" . $row['id'] . ");</script>";
					echo "<div id='panel'>";
					echo "<tr class='hv' id='course".$row['id']."'>";
					//echo "<td style='display:none;'>".$row['id']."</td>";
					echo "<tr>";
						echo "<th rowspan='3'>";
							$courseimage = explode(",", $row['course_image']);
							if ($row['course_image'] == "") {
								echo "<img src='imgs/default.jpg' alt=''>";
							}
							else {
								echo "<a href='". $row['course_link']."'><image src='" . $courseimage[0] . "' width = 175 height = 175 </image></a>";
							}
							echo "<br />";
							echo "<br />";
							$temp = $row['id'];
							if (isset($_SESSION['username'])) {
								$sql = $conn->query("SELECT * FROM mycourses WHERE user_id = " . $_SESSION['userid'] . " AND course_data_id = " . $temp);
								if ($sql->num_rows > 0) {
									echo "
										<button class='btn btn-block btn-primary disabled'><span class='glyphicon glyphicon-ok'></span> Already added!</button>
									";
								}
								else {
									echo "
										<button class='btn btn-block btn-primary btn-success' onclick='addCourse(" . $row['id'] . ")'><span class='glyphicon glyphicon-plus'></span> Add To MyCourses</button>
									";
								}
							}
							else {
								echo "
									<button class='btn btn-block btn-disabled'><span class='glyphicon glyphicon-pencil'></span> Login To Add Course</button>
								";
							}
						echo "</th>"; 						
						echo "<td>";
							echo "<a style='font-size:1.25em;' href='". $row['course_link']."'>". $row['title'] . "</a>";
							$siteToMatch = strpos($row['site'], "futurelearn");
							if ($siteToMatch === false) {
								echo "<span style='font-size:0.9em;'> " . $row['site'] . "</span>";
							}
							else {
								echo "<span style='font-size:0.9em;'> FutureLearn</span>";
							}
							echo "<br />";
							echo "<p style='font-size:0.9em;'>Instructor: " . $row['profname'] . "</p>";
						echo "</td>";
						echo "<th rowspan='3'>";
						foreach($image as $profimage)
						{
							if(($counter!=0) && ($counter %3==0))
							{
								echo "<br>";
								$counter = 0;
							}
							echo "<image src='" . $profimage. "' width = 100 height = 100</image>";
							$counter++;
						}
					   echo "</th>";
					   echo "</tr>";
					   echo "<tr>";
					   echo "<td>";
							echo "<p>";
								echo "<span class='glyphicon glyphicon-calendar'></span> Start date: ";
								echo "<span style='font-weight:bold;'>";
									if($row['start_date']=="0000-00-00")
										echo "Self Paced";
									else
										echo $row['start_date'];
								echo "</span>";
								echo "<br />";
								echo "<span class='glyphicon glyphicon-tasks'></span> Length: ";
								echo "<span style='font-weight:bold;'>";
									if($row['course_length']<=0)
										echo "Self Paced";
									else 
										echo $row['course_length'] . " days";
								echo "</span>";
								echo "<br />";
								echo "<span class='glyphicon glyphicon-tag'></span> Category: "; 
								      if($row['category'] == "")
										  echo "None";
									  else
										  echo $row['category'];
							echo "</p>";
						echo "</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>".$row['short_desc']."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style='background-color:#A6A6A6'></td>";
						echo "<td style='background-color:#A6A6A6'></td>";
						echo "<td style='background-color:#A6A6A6'></td>";
					echo "</tr>";	
					echo "</tr>";
					echo "</div>";
				}
			}
			
			if (isset($_GET['course_type'])) {
				getResult($count, $type);
			}
			else if (isset($_GET['searchstring'])) {
				getResult($count, $usersearch);
			}
			else {
				getResult($count, "all");
			}
		?>
		</tbody>
    </table>
	<nav>
	<ul class="pagination pagination-lg">
	<?php
		$range = 2;
		if ($currentpage > 1) {
			if (isset($_GET['course_type'])) {
				$params = "course_type=" . $_GET['course_type'];
			}
			else if (isset($_GET['searchstring'])) {
				$params = "searchstring=" . $_GET['searchstring'];
			}
			else { $params = ""; }			
			echo "<li class='enabled'><a href='{$_SERVER['PHP_SELF']}?$params&currentpage=1' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
			
			$prevpage = $currentpage - 1;
		}
		for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
			if (($x > 0) && ($x <= $totalpages)) {
				if (isset($_GET['course_type'])) {
					$params = "course_type=" . $_GET['course_type'];
				}
				else if (isset($_GET['searchstring'])) {
					$params = "searchstring=" . $_GET['searchstring'];
				}
				else { $params = ""; }
				
				if ($x == $currentpage) {					
					echo "<li class='active'><a href='$params&$x'>$x <span class='sr-only'>(current)</span></a></li>";					
				} else {					
					echo "<li><a href='{$_SERVER['PHP_SELF']}?$params&currentpage=$x'>$x</a></li>";
				}
			}
		}
		if ($currentpage != $totalpages) {
			if (isset($_GET['course_type'])) {
				$params = "course_type=" . $_GET['course_type'];
			}
			else if (isset($_GET['searchstring'])) {
				$params = "searchstring=" . $_GET['searchstring'];
			}
			else { $params = ""; }
			$nextpage = $currentpage + 1;			
			echo"<li> <a href='{$_SERVER['PHP_SELF']}?$params&currentpage=$totalpages' aria-label='Next'><span aria-hidden='true'>&raquo;</span> </a>";
		}
	?>
	<li style="margin-left:10px;font-size:1.5em;">
		<?php
			if (($offset + 10) > $count) {
				echo "Showing " . $offset . " to " . $count . " of " . $count . " courses"; 
			}
			else if ($offset < 1) {
				echo "Showing " . ($offset + 1) . " to " . ($offset + 10) . " of " . $count . " courses"; 
			}
			else {
				echo "Showing " . $offset . " to " . ($offset + 10) . " of " . $count . " courses"; 
			}
		?>
	</li>
	</ul>
	</nav>
		<script>
			document.getElementById("coursetable").style.display = "block";
		</script>
	</div>
</br>
</body>
