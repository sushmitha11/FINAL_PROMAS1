<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "promas";
$list=$_POST['list'];
$email=$_SESSION['username'];
$message =$_POST['comment'];
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$subject = "HTML email";
$message =$_POST['comment'];
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: n.s.sushmitha11@gmail.com" . "\r\n";
$too = "somebody@example.com, somebodyelse@example.com";
$headers .= 'Cc:'.$list . "\r\n";//"Cc: '".$emails['EMAIL']."'" . "\r\n";
echo $headers;
if(mail($too,$subject,$message,$headers))
echo "sent";
else
	echo "not sent";
}
mysqli_close($conn);
?>