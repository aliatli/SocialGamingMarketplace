<?php
session_start();
include_once 'config.php';
if(isset($_SESSION['UserID'])){
  $user_id = $_SESSION['UserID'];
  $group_id = $_GET['GroupID'];
  $write_comment = $_POST['write_comment'];
  $sql_rec = "SELECT * FROM Grp WHERE Name = '$group_id';";
  $result_get_rec = mysqli_query($conn, $sql_rec);
  if($row = mysqli_fetch_assoc($result_get_rec)){
    $rec_id = $row['GroupID'];
    $rec_name = $row['Name'];
    $rec_date = $row['CreationDate'];
  }
  if(empty($group_id) || empty($rec_id) || empty($write_comment)){
    header("Location: ../~$dbusername/store.php");
    exit();
  }
  $sql = "INSERT INTO Comment(UserUserID, GroupGroupID, Content, Date) VALUES($user_id, $rec_id, '$write_comment', now())";
  $result = mysqli_query($conn, $sql);
  header("Location: ../~$dbusername/group.php?GroupID=$group_id");
  exit();
}
else{
  header("Location: ../~$dbusername/register_login.php");
  exit();
}
?>