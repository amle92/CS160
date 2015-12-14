<?php
    session_unset();
	session_start();
	
	require_once('dbconnect.php');
	if (isset($_GET['userid']) && isset($_GET['courseid'])) {
		$userid = $_GET['userid'];
		$courseid = $_GET['courseid'];
		$insertsql = $conn -> query("INSERT INTO mycourses (user_id, course_data_id) VALUES ('$userid', '$courseid')");
	}
?>