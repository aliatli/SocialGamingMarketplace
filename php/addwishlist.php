<?php
session_start();
include_once 'config.php';
    if(isset($_SESSION['UserID'])){
      $user_id = $_SESSION['UserID'];
      $game_id = $_POST['GameID'];
      $check = "SELECT * FROM WishList WHERE UserUserID='$user_id' AND GameGameID='$game_id'";
      $result = mysqli_query($conn, $check);
      $result_check = mysqli_num_rows($result);
      if($result_check == 0){
      $sql = "INSERT INTO WishList (UserUserID, GameGameID) VALUES('$user_id', '$game_id')";
      $result = mysqli_query($conn, $sql);
      header("Location: ../~$dbusername/game.php?GameID=$game_id");
      }
      else{
	$sql = "DELETE FROM WishList WHERE UserUserID='$user_id' AND GameGameID='$game_id'";
        $result = mysqli_query($conn, $sql);
	header("Location: ../~$dbusername/game.php?GameID=$game_id");
      }
   }
   else{
    header("Location: ../~$dbusername/game.php?GameID=$game_id");
    exit();
   }
?>