<html>
<head>
</head>
<body>
<?php

$phone = $_REQUEST['phone'];
$USN = $_REQUEST['USN'];
$sem=$_REQUEST['sem'];
$pass=$_REQUEST['user_passwd'];
$conf=$_REQUEST['confpasswd'];

if($conf != $pass)
{
	$message = "confirm password not correct!";
  echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
  echo "<script>setTimeout(\"location.href = '../registerPage.html';\",1500);</script>";
}
else if(!preg_match("/^[0-9]$/", $sem)) {
  $message = "Invalid semester";
  echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
  echo "<script>setTimeout(\"location.href = '../registerPage.html';\",1500);</script>";
}
else if(!preg_match("/^[0-9]{10}$/", $phone)) {
  $message = "Invalid Phone Number";
  echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
  echo "<script>setTimeout(\"location.href = '../registerPage.html';\",1500);</script>";
}

else if(!preg_match("/^[0-9][a-zA-Z]{2}[0-9]{2}[a-zA-Z]{2}[0-9]{3}$/", $USN)) {
	  $message = "Invalid USN Number";
	  echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
	  echo "<script>setTimeout(\"location.href = '../registerPage.html';\",1500);</script>";
	}
else if(!preg_match("/^[0-9][a-zA-Z]{2}[0-9]{2}[a-zA-Z]{2}[0-9]{3}$/", $USN)) {
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
			$type_user = 3;
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt))
			{
				// Prepare an insert statement
				$sql = "INSERT INTO students (username, name, USN, department, semester, phone, email, teamID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
				 
				if($stmtStudent = mysqli_prepare($link, $sql))
				{
					// Bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmtStudent, "ssssissi", $username, $name, $USN, $dept, $sem, $phone, $email, $teamID);
					
					$username = $_REQUEST['username'];
					$name = $_REQUEST['name'];
					$USN = $_REQUEST['USN'];
					$dept = $_REQUEST['department'];
					$sem = $_REQUEST['sem'];
					$phone = $_REQUEST['phone'];
					$email = $_REQUEST['email'];
					$result = $link->query("SELECT * FROM team");
					$rows = mysqli_num_rows($result);
					
					$sqlinc = "SELECT * from team where TeamName = ?";
					$stmtcheckinc = mysqli_prepare($link, $sqlinc);
					mysqli_stmt_bind_param($stmtcheckinc, "s", $teamName);
					$teamName = $_REQUEST['team'];
					mysqli_stmt_execute($stmtcheckinc);
					$result = mysqli_stmt_get_result($stmtcheckinc);
					$rows = mysqli_num_rows($result);
					if($rows != 0)
						$teamID = $result->fetch_assoc()['TeamID'];
					else
					{
						$resultnew = $link->query("SELECT * FROM team");
						$rows_new = mysqli_num_rows($resultnew);
						$teamID = $rows_new + 1;
					}
					$stmtcheckinc->close();        
					// Attempt to execute the prepared statement
					if(mysqli_stmt_execute($stmtStudent))
					{
						// Prepare an insert statement
						$sql = "SELECT * from team where TeamName = ?";
						 
						if($stmtcheck = mysqli_prepare($link, $sql)){
							// Bind variables to the prepared statement as parameters
							mysqli_stmt_bind_param($stmtcheck, "s", $teamName);
							
							$teamName = $_REQUEST['team'];
							mysqli_stmt_execute($stmtcheck);
							$result = mysqli_stmt_get_result($stmtcheck);
							$rows = mysqli_num_rows($result);
							if($rows == 0)
							{
								$sql = "INSERT INTO team (TeamID, TeamName) VALUES (?, ?)";
						 
								if($stmtTeam = mysqli_prepare($link, $sql)){
									// Bind variables to the prepared statement as parameters
									mysqli_stmt_bind_param($stmtTeam, "is", $teamid_new, $teamName);
									
									$result = $link->query("SELECT * FROM team");
									$rows = mysqli_num_rows($result);

									$teamid_new = $teamID;
									$teamName = $_REQUEST['team'];
									
									// Attempt to execute the prepared statement
									if(mysqli_stmt_execute($stmtTeam)){
										echo "<h3>You have successfully registered</h3>
												<a href=\"../loginPage.html\">
											  <button>Click here to continue</button></a>";
									} 
									else
									{
										$message = "Username already exists";
										echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
										echo "<script>setTimeout(\"location.href = '../loginPage.html';\",1500);</script>";
									}
								} 
								else
								{
									echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
								}
								mysqli_stmt_close($stmtTeam);
							}
							else
							{
								echo "<h3>You have successfully registered</h3>
												<a href=\"../loginPage.html\">
											  <button>Click here to continue</button></a>";
							}
						}
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
				mysqli_stmt_close($stmtStudent);
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
		// Close statement
		mysqli_stmt_close($stmt);
		// Close connection
		mysqli_close($link);	
	}

?>
    
</body>
</html>
