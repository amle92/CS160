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