<?php
session_start();
include_once 'config.php';
    if(isset($_SESSION['UserID'])){
     if(isset($_POST['GameID'])){
      $user_id = $_SESSION['UserID'];
      $game_id = $_POST['GameID'];
      $sql = "SELECT Balance FROM User WHERE UserID='$user_id'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);

      $balance = $row['Balance'];
      $sql = "SELECT Price FROM Game WHERE GameID='$game_id'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      $price = $row['Price'];
      if($price <= $balance){
        $sql = "INSERT INTO Buy (UserUserID, GameGameID) VALUES('$user_id', '$game_id')";
        $result = mysqli_query($conn, $sql);
	$newbalance = ((double)$balance) - ((double)$price);
	$sql = "UPDATE User SET Balance = '$newbalance' WHERE UserID = '$user_id'";
	$result = mysqli_query($conn, $sql);
        header("Location: ../~$dbusername/game.php?GameID=$game_id");
      }
      else{
	header("Location: ../~$dbusername/game.php?GameID=$game_id");
      }
     }
     else if(isset($_POST['GameIDCard'])){
      $user_id = $_SESSION['UserID'];
      $game_id = $_POST['GameIDCard'];
      $sql = "SELECT CardNo, Cvv FROM User WHERE UserID='$user_id'";
      $result = mysqli_query($conn, $sql);
      $row = mysql_fetch_assoc($result);
      if(is_null($row['Cvv']) || is_null($row['CardNo']))	
      	header("Location: ../~$dbusername/game.php?GameID=$game_id");
      else{
	$sql = "INSERT INTO Buy (UserUserID, GameGameID) VALUES('$user_id', '$game_id')";
	$result = mysqli_query($conn, $sql);
	header("Location: ../~$dbusername/game.php?GameID=$game_id");
      }
     }
   }
   else{
    header("Location: ../~$dbusername/game.php?GameID=$game_id");
    exit();
   }
?>
