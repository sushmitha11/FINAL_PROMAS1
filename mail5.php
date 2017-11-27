<?php
session_start();


//<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "promas_db";
$email=$_SESSION['username'];
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
$sql1="SELECT GuideID FROM guide WHERE username='".$email."'";
$result1=mysqli_query($conn, $sql1);
$guideid = mysqli_fetch_array($result1,MYSQLI_ASSOC);
//echo $guideid['GuideID'];
$sql2 = "SELECT teamID FROM team WHERE GuideID='".$guideid['GuideID']."'";
$result2=mysqli_query($conn, $sql2);
$teamids = mysqli_fetch_array($result2,MYSQLI_ASSOC);
$a=mysqli_num_rows($result2);
//echo $teamids['teamID'];
echo "<html><body><form action='./mail7.php' method='post'>
SELECT FROM THE DROPDOWN LIST TO WHICH TEAM YOU WANT TO SEND THE MESSAGE TO: 
<select name='list'>";
$count=1;
echo "hi";
while($count <= $a)
{
	$teamids = mysqli_fetch_array($result2,MYSQLI_ASSOC);
	echo "<option value='12'>" . $teamids['TeamID'] . "</option>";
	$count += 1;
}
echo "<br><br>
ENTER MESSAGE HERE!<br><br>
<input type='text' name='comment' size='500'><br><br>
<input type='submit' value='send'></form></body></html>";
mysqli_close($conn);

?>