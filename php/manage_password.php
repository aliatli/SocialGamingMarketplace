<?php
session_start();
include_once 'config.php';
if(isset($_POST['manage_password'])){
  $old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
  $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
  $password_confirm = mysqli_real_escape_string($conn, $_POST['password_confirm']);
  $user_id = $_SESSION['UserID'];

  if(empty($new_password)){
    header("Location: ../~$dbusername/manage_info.php?content=manage_password");
    exit();
  }

  if($old_password !== $password_confirm){
    header("Location: ../~$dbusername/manage_info.php?content=manage_password");
    exit();
  }

  $sql_compare = "SELECT * FROM User WHERE UserID = $user_id;";
  $result_compare = mysqli_query($conn, $sql_compare);
  if($row = mysqli_fetch_assoc($result_compare)){
    $hashed_password_check = password_verify($old_password, $row["Password"]);
    if($hashed_password_check == False){
      header("Location: ../~$dbusername/manage_info.php?content=manage_password");
      exit();
    }
    else if($hashed_password_check == True){
      $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
      $sql = "UPDATE User SET Password = '$hashed_password' WHERE UserID = $user_id;";

      mysqli_query($conn, $sql);

      header("Location: ../~$dbusername/manage_info.php?content=manage_password");
      exit();
    }
  }
}
else{
  header("Location: ../~$dbusername/register_login.php");
  exit();
}
?>
