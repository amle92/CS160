<?php
//you can insert PhP code in HTML by a pair of tags as shown in this 3 line statements
//require_once("connect.php");//provide a file that contains the database connection info
$conn = mysqli_connect("localhost", "root", "password", "moocs160");
?>
<head>
<title>OnCourse</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="stylesheet.css" />
	
	<style>
		body {
			background-color: rgb(167,191,196);
		}
		table, th, td {
		background-color: rgb(247,247,247);
		}
		th {
			text-align: center;
		}
	</style>
</head>
<body>
<br><!--start printing a table header containing all relevant fields' name-->
	<div class="container-fluid">
    <table class="footable footable-sortable table table-bordered" id="coursetable" data-page-size="6">
        <thead>
            <th data-sort-ignore="true">Image</th>
            <th data-sort-ignore="true">Course Name</th>
            <th data-sort-ignore="true">Short Description</th>
            <th data-sort-ignore="true">Category</th>
            <th data-sort-ignore="true">Start Date</th>
            <th data-sort-ignore="true">Course Length(Weeks)</th>
            <th data-sort-ignore="true">Site</th>
            <!--more here-->
        </thead>
		<?php
		//get the scraped data from database
		$result=$conn->query("SELECT * FROM course_data order by rand() limit 24");
		 
		if($result)
		{
			 while($row = $result->fetch_assoc())
					/* fetch associative array (there are multiple rows of matching data) */
					{
						$id = $row['id'];
						//print all the data to the table by rows
						echo "<tr class='hv' id='course".$row['id']."'>";
						echo "<td style='display:none;'>".$row['id']."</td>";
						echo "<td><a href='CoursePage.php?course=".$row['id']."'><image src='" . $row['course_image'] . "'</image></a></td>"; 
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
					}
		}
		?>
        
    </table>
	</div>
</br>
</body>
