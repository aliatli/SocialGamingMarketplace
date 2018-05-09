<?php
$dbservername = "dijkstra.ug.bcc.bilkent.edu.tr";
$dbusername = "ulas.is";
$dbpassword = "7fq5bg09";
$dbname = "ulas_is";

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if(!$conn){
  echo "<script>console.log('Connection is failed: " . mysqli_connect_error() . "!');</script>";
}
else{
  echo "<script>console.log('Connection is successful!');</script>";
}
?>
