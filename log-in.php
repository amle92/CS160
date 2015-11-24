<?php
session_unset();
error_reporting(0);
session_start();
require_once('dbconnect.php');
	if( isset($_POST['userName']) && isset($_POST['password']) ){
		
		if($conn){	
			$usernameEntered = $_POST['userName'];
			$passwordEntered = $_POST['password'];
			$sqlquery = $conn -> query("SELECT password FROM users WHERE username = '$usernameEntered' "); 
            	if ($sqlquery) {       
       					while ($row = mysqli_fetch_array($sqlquery)) {
						$passwordFromDb = $row[0];
					}
						mysql_close($conn);
						
						echo $passwordFromDb;
						if($passwordEntered == $passwordFromDb){
							$_SESSION['username'] = $usernameEntered;
							header('Location: index.php');
							}
						else{
							header('Location:login.php');
							
						} 	
				}
		
	}
}
	else{
    http_response_code(400);
  }
?>