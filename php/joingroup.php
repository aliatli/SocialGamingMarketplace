<?php
session_start();
include_once 'config.php';
if(isset($_SESSION['UserID'])){
  $user_id = $_SESSION['UserID'];
  $group_id = $_GET['GroupID'];
  if(empty($group_id)){
    header("Location: ../~$dbusername/community.php");
    exit();
  }
  else{
    $sql = "SELECT GroupID, Name FROM Grp WHERE Name = '$group_id'";
    $result = mysqli_query($conn, $sql);
    $res = mysqli_fetch_assoc($result);
    $id = $res['GroupID'];
    $name = $res['Name'];
    $sql = "SELECT * FROM Member WHERE UserUserID = '$user_id' AND GroupGroupID = '$id'";
    $result = mysqli_query($conn, $sql);
    $no = mysqli_num_rows($result);
    if($no == 0){
      $sql = "INSERT INTO Member(UserUserID, GroupGroupID, Date) VALUES($user_id, $id, now())";
      $result = mysqli_query($conn, $sql);
      header("Location: ../~$dbusername/group.php?GroupID=$name");
    }
    else{
      $sql = "DELETE FROM Member WHERE UserUserID = '$user_id' AND GroupGroupID = '$id'";
      $result = mysqli_query($conn, $sql);
      header("Location: ../~$dbusername/group.php?GroupID=$name");
    }
  }
}
else{
  header("Location: ../~$dbusername/register_login.php");
  exit();
}
?>