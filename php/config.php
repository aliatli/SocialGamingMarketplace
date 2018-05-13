<?php
$dbservername = "dijkstra.ug.bcc.bilkent.edu.tr";
$dbusername = "cagatay.kupeli";
$dbpassword = "rxtnb2bwh";
$dbname = "cagatay_kupeli";
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
if(!$conn){
  echo "<script>console.log('Connection is failed: " . mysqli_connect_error() . "!');</script>";
}
else{
  echo "<script>console.log('Connection is successful!');</script>";
}
?>
