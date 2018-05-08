<?php
if(isset($_POST['register'])){
  include_once 'config.php';

  $email_or_username = mysqli_real_escape_string($conn, $_POST['email_or_username']);
  $password_login = mysqli_real_escape_string($conn, $_POST['password_login']);

  if(empty($email_or_username) || empty($password_login)){
    header("Location: ../register_login.php?error_empty");
    exit();
  }
  else{
    $sql_compare_username = "SELECT * FROM User WHERE UserName = '$email_or_username' AND Password = '$password_login'";
    $result_username = mysqli_query($conn, $sql_compare_username);
    $result_check_username = mysqli_num_rows($result_username);

    $sql_compare_email = "SELECT * FROM User WHERE Email = '$email_or_username' AND Password = '$password_login'";
    $result_email = mysqli_query($conn, $sql_compare_email);
    $result_check_email = mysqli_num_rows($result_email);

    if($result_check_username === 0 && $result_check_email === 0){
      header("Location: ../register_login.php?error_unvalid_username_or_password");
      exit();
    }
    else if($result_check_username !== 0){
      if($row_username = mysqli_fetch_assoc($result_username)){
        $hashed_password_check_1 = password_verify($password_login, $row_username['PASSWORD']);
        if($hashed_password_check_1 === FALSE){
          header("Location: ../register_login.php?error_login");
          exit();
        }
        else if($hashed_password_check_1 === TRUE){
          //login
          $_SESSION['UserID'] = $row_username['UserID'];
          header("Location: ../store.php?");
          exit();
        }
      }
    }
    else if($result_check_email !== 0){
      if($row_email = mysqli_fetch_assoc($result_email)){
        $hashed_password_check_2 = password_verify($password_login, $row_email['PASSWORD']);
        if($hashed_password_check_2 === FALSE){
          header("Location: ../register_login.php?error_login");
          exit();
        }
        else if($hashed_password_check_2 === TRUE){
          //login
          $_SESSION['UserID'] = $row_email['UserID'];
          header("Location: ../store.php?");
          exit();
        }
      }
    }
  }
}
else{
  header("Location: ../register_login.php");
  exit();
}
?>
