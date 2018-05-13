<?php
session_start();
include_once 'config.php';
if(isset($_SESSION['UserID'])){
  $user_id = $_SESSION['UserID'];
  $group_name = mysqli_real_escape_string($conn, $_POST['create_group']);
  
  if(empty($group_name)){
    header("Location: ../~$dbusername/community.php");
    exit();
  }
  else{
    $sql = "INSERT INTO Grp(Name, CreationDate) VALUES('$group_name', now())";
    $result = mysqli_query($conn, $sql);
    $sql = "SELECT GroupID FROM Grp WHERE Name = '$group_name'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $gid = $row['GroupID'];
    $sql = "INSERT INTO Member(UserUserID, GroupGroupID, Date) VALUES($user_id, $gid, now())";
    $result = mysqli_query($conn, $sql);
    header("Location: ../~$dbusername/community.php");
  }
}
else{
  header("Location: ../~$dbusername/register_login.php");
  exit();
}
?>