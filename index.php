<?php
//require_once("connect.php");//provide a file that contains the database connection info
/*change the credentials according to yours*/
$conn = mysqli_connect("localhost", "youthcyb_160s2g4", "password", "test1");
?>
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
			<li><a href="#"><span class="glyphicon glyphicon-user"></span> Register</a></li>
			<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
		  </ul>
		</div>
	  </div>
</nav>
<br><!--start printing a table header containing all relevant fields' name-->
	<div class="container-fluid">
	<br />
	<br />
	<br />
    <table class="footable footable-sortable table table-bordered" id="coursetable" data-page-size="6">
        <thead>
            <th data-sort-ignore="true">Image</th>
            <th data-sort-ignore="true">Course Name</th>
            <th data-sort-ignore="true">Short Description</th>
            <th data-sort-ignore="true">Category</th>
            <th data-sort-ignore="true">Start Date</th>
            <th data-sort-ignore="true">Course Length(Days)</th>
            <th data-sort-ignore="true">Site</th>
            <!--more here-->
        </thead>
		<?php
			$result=$conn->query("SELECT * FROM course_data order by title ASC"); //limit 24");
			//$usersearch = $_GET['searchstring'];
			//$matchesfound = 0;
			
			//Change this url to specified directory
			//$errorurl = "error.php";
			
			if($result)
			{
				//echo "<h3><p class='text-center'>Results containing the keyword: " . $usersearch . "</p></h3>";
				 while($row = $result->fetch_assoc())
				/* fetch associative array (there are multiple rows of matching data) */
				{
					//if (stripos($row['title'], $usersearch) !== false) {
						$id = $row['id'];
						//print all the data to the table by rows
						echo "<tr class='hv' id='course".$row['id']."'>";
						echo "<td style='display:none;'>".$row['id']."</td>";
						echo "<td><a href='CoursePage.php?course=".$row['id']."'><image src='" . $row['course_image'] . "' width = 175 height = 175 </image></a></td>"; 
						echo "<td><a href='CoursePage.php?course=".$row['id']."'>". $row['title'] . "</a></td>";
						echo "<td>".$row['short_desc']."</td>";
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
						//$matchesfound++;
					//}
				}
				/*  if ($matchesfound == 0) {
					header("Location: $errorurl"); 
				} */
			}
		?>
    </table>
	</div>
</br>
</body>
