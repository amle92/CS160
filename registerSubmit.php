<?php
require_once('dbconnect.php');
if( isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) ){    	
	if ($conn){
		$firstName = $_POST['fname'];
		$lastName = $_POST['lname'];
		$userName = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$insertsql = $conn -> query("INSERT INTO USERS (first_name, last_name, Username, Password, Email) VALUES ('$firstName', '$lastName', '$userName', '$password', '$email') ");
		            
            if ($insertsql) {
				?>                        
				<script> alert('Successfully Registered');</script>
				<?php
				mysql_close($conn);
				header('Location: index.php');
				}
				else{
					?>
					<script> alert('error while trying to register'); </script>
					<?php
				}		
				
        }	
	}
?>