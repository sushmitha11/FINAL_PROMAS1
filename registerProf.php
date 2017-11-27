<html>
<head>
</head>
<body>
<?php

$phone = $_REQUEST['phone'];
$sem=$_REQUEST['sem'];
$pass=$_REQUEST['user_passwd'];
$conf=$_REQUEST['confpasswd'];

if($conf != $pass)
{
	$message = "confirm password not correct!";
  echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
  echo "<script>setTimeout(\"location.href = '../registerPage.html';\",1500);</script>";
}
else if(!preg_match("/^[0-9]{10}$/", $phone)) {
  $message = "Invalid Phone Number";
  echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
  echo "<script>setTimeout(\"location.href = '../registerPage.html';\",1500);</script>";
}
else
{
	$USN = $_REQUEST['USN'];

	if(!preg_match("/^[0-9][a-zA-Z]{2}[0-9]{2}[a-zA-Z]{2}[0-9]{3}$/", $USN)) {
	  $message = "Invalid USN Number";
	  echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
	  echo "<script>setTimeout(\"location.href = '../registerPage.html';\",1500);</script>";
	}
			else{
		//phpinfo();
		/* Attempt MySQL server connection. Assuming you are running MySQL
		server with default setting (user 'root' with no password) */
		$link = mysqli_connect("localhost", "root", "", "PROMAS_DB");

		// Check connection
		if($link === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}
		 
		// Prepare an insert statement
		$sql = "INSERT INTO users (username, passwd, type) VALUES (?, ?, ?)";
		 
		if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "ssi", $username, $mypassword, $type_user);
			
			$username = $_REQUEST['username'];
			$mypassword = $_REQUEST['user_passwd'];
			$type_user = 4;
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// Prepare an insert statement
				$sql = "INSERT INTO guide (username, GuideID, name, department, email, phone) VALUES (?, ?, ?, ?, ?, ?)";
				 
				if($stmtGuide = mysqli_prepare($link, $sql)){
					// Bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmtGuide, "sissss", $username, $GuideID, $name, $dept, $email, $phone);
					
					$username = $_REQUEST['username'];
					$name = $_REQUEST['name'];
					$dept = $_REQUEST['department'];
					$phone = $_REQUEST['phone'];
					$email = $_REQUEST['email'];

					$result = $link->query("SELECT * FROM guide");
					$rows = mysqli_num_rows($result);

					$GuideID = $rows + 1;
							
					// Attempt to execute the prepared statement
					if(mysqli_stmt_execute($stmtGuide))
					{
						echo "<h3>You have successfully registered</h3>
								<a href=\"../loginPage.html\">
							<button>Click here to continue</button>
							</a>";
					} 
					else
					{
						$message = "Username already exists";
						echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
						echo "<script>setTimeout(\"location.href = '../loginPage.html';\",1500);</script>";
					}
				} 
				else{
					echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
				}
				mysqli_stmt_close($stmtGuide);
			} 
			else
			{
				echo "ERROR: Could not execute query: $sql. " . mysqli_error($link);
			}
		} 
		else{
			echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
		}
		  
		// Close statement
		mysqli_stmt_close($stmt);
		// Close connection
		mysqli_close($link);
		}
	}

			
?>
   
</body>
</html>
