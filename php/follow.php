<?php
session_start();
include_once 'config.php';
if(isset($_SESSION['UserID'])){
  $user_id = $_SESSION['UserID'];

  if(isset($_GET['profile_id'])){
    $profile_id = $_GET['profile_id'];
  }
  else{
    header("Location: ../~$dbusername/profile.php?profile_no=$profile_id&page_game=1&page_review=1&page_follow=1&page_follow=1");
    exit();
  }

  if($user_id === $profile_id){
    header("Location: ../~$dbusername/profile.php?profile_no=$user_id&page_game=1&page_review=1&page_follow=1&page_follow=1");
    exit();
  }
  
  $sql_follow = "SELECT * FROM FriendList WHERE UserUserID = $user_id AND UserUserID2 = $profile_id;";
  $result_follow = mysqli_query($conn, $sql_follow);
  $result_follow_check = mysqli_num_rows($result_follow);

  if($result_follow_check === 0){
    $sql_insert = "INSERT INTO FriendList VALUES ($user_id, $profile_id);";
    mysqli_query($conn, $sql_insert);
  }
  else{
    $sql_delete = "DELETE FROM FriendList WHERE UserUserID = $user_id AND UserUserID2 = $profile_id;";
    mysqli_query($conn, $sql_delete);
  }

  header("Location: ../~$dbusername/profile.php?profile_no=$profile_id&page_game=1&page_review=1&page_follow=1&page_follow=1");
  exit();
}
else{
  header("Location: ../~$dbusername/register_login.php");
  exit();
}
?>