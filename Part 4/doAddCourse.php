
<?php
$sname = "localhost";
$user = "root";
$pass = "";
$dbname = "aqark";
$code = $_POST["code"];
$title = $_POST["title"];
$credit = $_POST["credit"];
// Create connection
$conn = new mysqli($sname, $user, $pass,$dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";
$sql="insert into courses(code,title,credit) 
      values ('$code','$title',$credit);";

$result = mysqli_query($conn, $sql);

print "<br/>Number of added courses is $result<br/>";

mysqli_close($conn);
?>
