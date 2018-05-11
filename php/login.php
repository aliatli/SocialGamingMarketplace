<?php
session_start();
include_once 'config.php';

if(isset($_POST['login'])){
  $email_or_username = mysqli_real_escape_string($conn, $_POST['email_or_username']);
  $password_login = mysqli_real_escape_string($conn, $_POST['password_login']);

  if(empty($email_or_username) || empty($password_login)){
    header("Location: ../~$dbusername/register_login.php?error_empty");
    exit();
  }
  else{
    $sql_compare = "SELECT * FROM User WHERE UserName = '$email_or_username' OR Email = '$email_or_username';";
    $result = mysqli_query($conn, $sql_compare);
    $result_check = mysqli_num_rows($result);

    if($result_check == 0){
      header("Location: ../~$dbusername/register_login.php?error_invalid_username");
      exit();
    }
    else{
      if($row = mysqli_fetch_assoc($result)){
        $hashed_password_check = password_verify($password_login, $row["Password"]);

        if($hashed_password_check == False){
          header("Location: ../~$dbusername/register_login.php?error_invalid_password");
          exit();
        }
        else if($hashed_password_check == True){
          //login
          $_SESSION['UserID'] = $row['UserID'];
          header("Location: ../~$dbusername/store.php");
          exit();
        }
      }
    }
  }
}
else{
  header("Location: ../~$dbusername/register_login.php");
  exit();
}
?>
