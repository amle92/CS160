<?php
$conn = mysqli_connect("localhost", "root", "", "youthcyb_cs160s2g4");
?>
<head>

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

<nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a>
		</div>
		<div>
		  <ul class="nav navbar-nav">
			<li><a href="#">About Us</a></li>
			<li><a href="print_scraped_data2browser.php">Courses</a></li>
			<li><a href="https://twitter.com/share" class="twitter-share-button" {count} data-url="http://www.sjsu-cs.org/cs160/sec2group4/" data-text="Check out all these amazing courses I found!">Tweet</a></li>
			<li><div class="fb-like" data-share="true" data-width="450" data-show-faces="true" data-colorscheme="dark"></div></li>
		  </ul>
			<ul id='user_access' class='nav navbar-nav navbar-right'>
			<li><a id='login'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>
			<li><a id='register'><span class='glyphicon glyphicon-user'></span> Register</a></li>
		  </ul>
		</div>
	  </div>
</nav>

<br><!--start printing a table header containing all relevant fields' name-->
	<div class="container-fluid">
	<div class="g-hangout" data-render="createhangout"></div>
	<br />
	<br />
	<br />
    <table class="footable footable-sortable table table-bordered" id="coursetable" data-page-size="6">
        <thead>
			<tr>
            <th data-sort-ignore="true">Course Image</th>
            <th data-sort-ignore="true">Course Name</th>
			<th data-sort-ignore="true">Professor Name</th>
			<th data-sort-ignore="true">Professor Image</th>
            <th data-sort-ignore="true">Short Description</th>
			<th data-sort-ignore="true">Video Link</th>
            <th data-sort-ignore="true">Category</th>
            <th data-sort-ignore="true">Start Date</th>
            <th data-sort-ignore="true">Course Length(Days)</th>
            <th data-sort-ignore="true">Site</th>
            <!--more here-->
			</tr>
        </thead>
		<tbody>
		<?php
			$result = $conn->query("SELECT * FROM course_data, coursedetails WHERE coursedetails.course_id = course_data.id order by title ASC");
			if(isset($_GET['searchstring'])) {
				$usersearch = $_GET['searchstring'];
			}
			
			if($result)
			{
				//echo "<h3><p class='text-center'>Results containing the keyword: " . $usersearch . "</p></h3>";
				while($row = $result->fetch_assoc())
				/* fetch associative array (there are multiple rows of matching data) */
				{
					if (isset($_GET['searchstring'])) {
						if (stripos($row['title'], $usersearch) !== false) {
							echo "<tr class='hv' id='course".$row['id']."'>";
							//echo "<td style='display:none;'>".$row['id']."</td>";
							echo "<td><a href='". $row['course_link']."'><image src='" . $row['course_image'] . "' width = 175 height = 175 </image></a></td>"; 						
							echo "<td><a href='". $row['course_link']."'>". $row['title'] . "</a></td>";
							echo "<td>".$row['profname']."</td>";
							echo "<td><image src='" .$row['profimage']. "' width = 175 heigh = 175 </image></a></td>";
							echo "<td>".$row['short_desc']."</td>";
							//echo "<td><a href='". $row['video_link']."'>". $row['video_link']. "</a></td>";
							echo "<td><video width=400 height=230 controls preload=none><source src='". $row['video_link'] ."' type = video/mp4></video></td>";
							//echo "<td>Video Link</td>";
							echo "<td>" . $row['category'] . "</td>";
							echo "<td>"; // start date
							if($row['start_date']=="0000-00-00")
								echo "Self Paced";
							else
								echo $row['start_date'];
							echo "</td>";          
							echo "<td>"; // Course Length
							if($row['course_length']<=0)
								echo "Self Paced";
							else 
								echo $row['course_length'];
							echo "</td>";          
							echo "<td>" . $row['site'] . "</td>"; // Site of origin					
							echo "</tr>";
						}
					}
					else {
						echo "<tr class='hv' id='course".$row['id']."'>";
						//echo "<td style='display:none;'>".$row['id']."</td>";
						echo "<td><a href='". $row['course_link']."'><image src='" . $row['course_image'] . "' width = 175 height = 175 </image></a></td>"; 						
						echo "<td><a href='". $row['course_link']."'>". $row['title'] . "</a></td>";
						echo "<td>".$row['profname']."</td>";
						echo "<td><image src='" .$row['profimage']. "' width = 175 heigh = 175 </image></a></td>";
						echo "<td>".$row['short_desc']."</td>";
						//echo "<td><a href='". $row['video_link']."'>". $row['video_link']. "</a></td>";
						echo "<td><video width=400 height=230 controls preload=none><source src='". $row['video_link'] ."' type = video/mp4></video></td>";
						//echo "<td>Video Link</td>";
						echo "<td>" . $row['category'] . "</td>";
						echo "<td>"; // start date
						if($row['start_date']=="0000-00-00")
							echo "Self Paced";
						else
							echo $row['start_date'];
						echo "</td>";          
						echo "<td>"; // Course Length
						if($row['course_length']<=0)
							echo "Self Paced";
						else 
							echo $row['course_length'];
						echo "</td>";          
						echo "<td>" . $row['site'] . "</td>"; // Site of origin					
						echo "</tr>";
					}
				}
			}
		?>
		</tbody>
    </table>
	</div>
	
	<div id="bg">
		<img id="cover" src="imgs/backcover.png" alt="">
	</div>
	
	<script>
		$(document).ready( function () {
			$('#coursetable').DataTable();
		});
	</script>
</br>
</body>
