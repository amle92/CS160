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
session_start();
?>
<title>OnCourse</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
	
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/dataTables.jqueryui.min.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.10/js/dataTables.jqueryui.min.js"></script>
	
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

<script>	
function removeCourse(course_id) {
if (window.XMLHttpRequest) {
// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp = new XMLHttpRequest();
} else {
// code for IE6, IE5
xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
var temp = <?php echo json_encode($_SESSION['userid']);?>;
xmlhttp.open("GET","removecourse.php?userid="+temp+"&courseid="+course_id,true);
xmlhttp.send();
window.location.replace("mycourses.php");
}
</script>

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
			<li class="active"><a href="mycourses.php">MyCourses</a></li>
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

<br><!--start printing a table header containing all relevant fields' name-->
	<div class="container-fluid">
	<div class="g-hangout" data-render="createhangout"></div>
	<br />
	<br />
	<br />
    <table class="footable footable-sortable table" id="coursetable">
		<tbody>
		<?php
			if (isset($_GET['course_type'])) {
				$type = $_GET['course_type'];
				$result = $conn->query("SELECT * FROM course_data, coursedetails WHERE coursedetails.course_id = course_data.id AND course_data.site = '$type' ORDER BY title ASC");
			}
			else {
				$result = $conn->query("SELECT course_data.*, coursedetails.course_id, coursedetails.profname, coursedetails.profimage 
										FROM course_data, users, mycourses, coursedetails 
										WHERE mycourses.user_id = " . $_SESSION['userid'] . "
											AND users.user_id = " . $_SESSION['userid'] . "
											AND course_data.id = mycourses.course_data_id
											AND coursedetails.course_id = course_data.id");
			}
			
			if($result)
			{
				while($row = $result->fetch_assoc())
				{
					$image = explode(",", $row['profimage']);
					$counter = 0;
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
                        echo "
						    <button class='btn btn-block btn-primary btn-danger' onclick='removeCourse(" . $row['id'] . ")'><span class='glyphicon glyphicon-minus'></span> Remove Course</button>
						";						
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
		?>
		</tbody>
    </table>
	</div>
	<!--
	<script>
		$(document).ready( function () {
			$('#coursetable').DataTable();
		});
	</script>
	-->
</br>
</body>
