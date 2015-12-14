<?php
	require_once('dbconnect.php');
	if(isset($_GET['user']) && isset($_GET['pass']) ) {
		if($conn){	
			$usernameEntered = $_GET['user'];
			$passwordEntered = $_GET['pass'];
			$found = "";
			
			if ($usernameEntered == "null") {
				echo "Please enter username";
			}
			else {
				$sqlquery = $conn -> query("SELECT * FROM users WHERE username = '$usernameEntered' "); 
				if ($sqlquery) {       
					while ($row = mysqli_fetch_array($sqlquery)) {
						$passwordFromDb = $row[4];
						$useridfromDB = $row[0];
						if($passwordEntered == $passwordFromDb){
							$found = "true";
							session_start();
							$_SESSION['username'] = $usernameEntered;
							$_SESSION['userid'] = $useridfromDB;	
							echo "success";
						}
					}
					if ($found == "") {
						echo "Username or password is incorrect";
					} 	
				}
				else {
					echo "Username is incorrect";
				}
			}
		}
	}
?>