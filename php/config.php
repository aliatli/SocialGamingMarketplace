<?php
$servername = "localhost";
$username = "root";
$password = "password";

$conn = mysqli_connect($servername, $username, $password);

if(!$conn){
  echo "<script>console.log('Connection is failed: " . mysqli_connect_error() . "!');</script>";
}
echo "<script>console.log('Connection is successful!');</script>";
?>
