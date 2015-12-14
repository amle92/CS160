<?php
	require_once('dbconnect.php');
	
	if(isset($_GET['user']) && isset($_GET['pass']) ){
		$fname = $_GET['fname'];
		$lname = $_GET['lname'];
		$username = $_GET['user'];
		$password = $_GET['pass'];
		$email = $_GET['email'];
		$insertsql = $conn -> query("INSERT INTO users (first_name, last_name, username, password, email) VALUES ('$fname', '$lname', '$username', '$password', '$email')");
	}
	echo "<script>console.log(" . $username . ");</script>";
?>