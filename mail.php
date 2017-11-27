

<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "promas_db";
$to=$_POST['selected'];
//echo $to;
$email=$_SESSION['username'];
$message =$_POST['comment'];



// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if($to == "1")
{
	$sql1 = "SELECT email FROM students WHERE username='".$email."'";
$result1=mysqli_query($conn, $sql1);
$team = mysqli_fetch_array($result1,MYSQLI_ASSOC);
//echo $team['email'];
$sql2 = "SELECT teamID FROM students WHERE email='".$team['email']."'";
$result2=mysqli_query($conn, $sql2);
$teamid = mysqli_fetch_array($result2,MYSQLI_ASSOC);
$sql3 = "SELECT email FROM students WHERE teamID='".$teamid['teamID']."' AND email !='".$team['email']."'";
$result3=mysqli_query($conn, $sql3);
$emails = mysqli_fetch_array($result3,MYSQLI_ASSOC);
$a=mysqli_num_rows($result3);
$subject = "HTML email";
$message =$_POST['comment'];
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


$headers .= "From: n.s.sushmitha11@gmail.com" . "\r\n";
$count=0;
while($count<$a)
{$count +=1;
$too = "somebody@example.com, somebodyelse@example.com";

$headers .= 'Cc:'.$emails['email'] . "\r\n";//"Cc: '".$emails['EMAIL']."'" . "\r\n";
//echo $headers;
if(mail($too,$subject,$message,$headers))
{
echo "sent";
echo "<html><body><script>setTimeout(\"location.href = './index.php';\",1500);</script></body></html>";
}
else
	echo "not sent";
}
}
if($to == "2")
{
	$sql10 = "SELECT email FROM student WHERE username='".$email."'";
$result10=mysqli_query($conn, $sql10);
$team = mysqli_fetch_array($result10,MYSQLI_ASSOC);
$sql1 = "SELECT TeamID FROM student WHERE email='".$team['email']."'";
$result1=mysqli_query($conn, $sql1);
$guideid = mysqli_fetch_array($result1,MYSQLI_ASSOC);
echo $guideid['GuideID'];
$sql2 = "SELECT GuideID FROM team WHERE TeamID='".$guideid['TeamID']."'";
$result2=mysqli_query($conn, $sql2);
$guideids = mysqli_fetch_array($result2,MYSQLI_ASSOC);
$sql4 = "SELECT EMAIL FROM guide WHERE GuideID='".$guideids['GUIDEID']."'";
$result4=mysqli_query($conn, $sql4);
$emails = mysqli_fetch_array($result4,MYSQLI_ASSOC);
$to1="somebody@example.com, somebodyelse@example.com";
$subject = "HTML email";
//echo $emails;
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: n.s.sushmitha11@gmail.com' . "\r\n";

$headers .= 'Cc:'.$emails['email'] . "\r\n";
//echo $headers;
if(mail($to1,$subject,$message,$headers))
{
echo "sent";
echo "<html><body><script>setTimeout(\"location.href = './index.php';\",1500);</script></body></html>";
}
else echo "not sent";
}
	




mysqli_close($conn);

?>