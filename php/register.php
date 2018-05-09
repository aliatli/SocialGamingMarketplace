<?php
if(isset($_POST['register'])){
  include_once 'config.php';

  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
  $password_register = mysqli_real_escape_string($conn, $_POST['password_register']);
  $password_again = mysqli_real_escape_string($conn, $_POST['password_again']);
  $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);

  //Check the correctness of input
  //Check for empty fields
  if(empty($email) || empty($username) || empty($firstname) || empty($lastname) || empty($password_register) || empty($password_again) || empty($date_of_birth)){
    header("Location: ../~$dbusername/register_login.php?error_empty");
    exit();
  }
  else{
    //Check for validness
    if(strlen($date_of_birth) !== 10){
      header("Location: ../~ulas.is/register_login.php?error_invalid_date");
      exit();
    }
    else if($password_register !== $password_again){
      header("Location: ../~ulas.is/register_login.php?error_passwords_not_match");
      exit();
    }
    else{
      //Check if e_mail is valid
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../~ulas.is/register_login.php?error_invalid_email");
        exit();
      }
      else{
        $sql_compare = "SELECT * FROM User WHERE UserName = '$username' OR Email = '$email'";
        $result = mysqli_query($conn, $sql_compare);
        $result_check = mysqli_num_rows($result);

        if($result_check < 0){
          header("Location: ../~ulas.is/register_login.php?error_user_taken");
          exit();
        }
        else {
          date_default_timezone_set('Europe/Istanbul');
          $date_of_birth_convention = strtotime($date_of_birth);
          $hashed_password = password_hash($password_register, PASSWORD_DEFAULT);

          $sql_insert = "INSERT INTO User (FirstName, LastName, UserName, Email, DateOfBirth, Balance, CardNo, Cvv, BillingAddress) VALUES ('$firstname', '$lastname', '$username', '$email', '$date_of_birth_convetion', '0', '', '', '');"\
;
          mysqli_query($conn, $sql_insert);

          header("Location: ../~ulas.is/store.php");
          exit();
        }
      }
    }
  }
}
else{
  header("Location: ../~ulas.is/register_login.php");
  exit();
}
?>
