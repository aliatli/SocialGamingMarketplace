<?php
session_start();
include_once 'config.php';
if(isset($_POST['add_balance'])){
  $new_balance = mysqli_real_escape_string($conn, $_POST['new_balance']);
  $user_id = $_SESSION['UserID'];

  if(empty($new_balance)){
    header("Location: ../~$dbusername/manage_info.php?content=add_balance");
    exit();
  }

  $sql_old_balance = "SELECT * FROM User WHERE UserID = $user_id;";
  $result_old_balance = mysqli_query($conn, $sql_old_balance);
  if($row = mysqli_fetch_assoc($result_old_balance)){
    $old_balance = $row['Balance'];
  }

  $new_balance = $new_balance + $old_balance;

  $sql = "UPDATE User SET Balance = $new_balance WHERE UserID = $user_id;";
  mysqli_query($conn, $sql);

  header("Location: ../~$dbusername/manage_info.php?content=manage_password");
  exit();

}
else{
  header("Location: ../~$dbusername/register_login.php");
  exit();
}
?>