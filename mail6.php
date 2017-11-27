<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "promas";
$email=$_SESSION['username'];
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}
$sql1="SELECT GUIDEID FROM teacher WHERE EMAIL='".$email."'";
$result1=mysqli_query($conn, $sql1);
$guideid = mysqli_fetch_array($result1,MYSQLI_ASSOC);
$sql2 = "SELECT EMAIL FROM student1 WHERE GUIDEID='".$guideid['GUIDEID']."'";
$result2=mysqli_query($conn, $sql2);
//$emails = mysqli_fetch_array($result2,MYSQLI_ASSOC);
$a=mysqli_num_rows($result2);
echo "<html><body><form action='http://localhost/myprojects/working_php_code_promas/mail8.php' method='post'>
SELECT FROM THE DROPDOWN LIST TO WHICH TEAM YOU WANT TO SEND THE MESSAGE TO: 
<select name='list'>";
$count=1;
while($count < $a)
{
	$emails = mysqli_fetch_array($result2,MYSQLI_ASSOC);
	echo "<option value='".$emails['EMAIL']."'>'".$emails['EMAIL']."'</option>";
	$count +=1;
}
echo "<input type='text' name='comment' size='500'><br><br>
<input type='submit' value='send'></form></body></html>";
mysqli_close($conn);
?>