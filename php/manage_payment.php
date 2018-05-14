<?php
session_start();
include_once 'config.php';
if(isset($_POST['manage_payment'])){
  $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);
  $card_no = mysqli_real_escape_string($conn, $_POST['card_no']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $user_id = $_SESSION['UserID'];

  if(!(empty($card_no) || strlen($card_no) === 19)){
    header("Location: ../~$dbusername/manage_info.php");
    exit();
  }

  if(empty($cvv) && empty($card_no) && empty($address)){
    $sql = "UPDATE User SET Cvv = NULL, CardNo = NULL, BillingAddress = NULL WHERE UserID = $user_id;";
  }
  else if(empty($cvv) && empty($card_no)){
    $sql = "UPDATE User SET Cvv = NULL, CardNo = NULL, BillingAddress = '$address' WHERE UserID = $user_id;";
  }
  else if(empty($card_no) && empty($address)){
    $sql = "UPDATE User SET Cvv = $cvv, CardNo = NULL, BillingAddress = NULL WHERE UserID = $user_id;";
  }
  else if(empty($cvv) && empty($address)){
    $sql = "UPDATE User SET Cvv = NULL, CardNo = '$card_no', BillingAddress = NULL WHERE UserID = $user_id;";
  }
  else if(empty($cvv)){
    $sql = "UPDATE User SET Cvv = NULL, CardNo = '$card_no', BillingAddress = '$address' WHERE UserID = $user_id;";
  }
  else if(empty($card_no)){
    $sql = "UPDATE User SET Cvv = $cvv, CardNo = NULL, BillingAddress = '$address' WHERE UserID = $user_id;";
  }
  else if(empty($address)){
    $sql = "UPDATE User SET Cvv = $cvv, CardNo = '$card_no', BillingAddress = NULL WHERE UserID = $user_id;";
  }
  else{
    $sql = "UPDATE User SET Cvv = $cvv, CardNo = '$card_no', BillingAddress = '$address' WHERE UserID = $user_id;";
  }

  mysqli_query($conn, $sql);

  header("Location: ../~$dbusername/manage_info.php");
  exit();

}
else{
  header("Location: ../~$dbusername/register_login.php");
  exit();
}
?>
