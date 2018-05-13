<?php
session_start();
include_once 'config.php';
if(isset($_SESSION['UserID'])){
  $comment = mysqli_real_escape_string($conn, $_POST['comment']);
  $user_id = $_SESSION['UserID'];
  $game_id = $_POST['GameID'];
  $post_rate = (isset($_POST['rating'])) ? $_POST['rating'] : 0;
  
  $sql = "INSERT INTO Write_Review (UserUserID, GameGameID, Comment, Rating, Date) VALUES ('$user_id', '$game_id', '$comment', '$post_rate', now())";
  $result = mysqli_query($conn, $sql);
  if($result){
    $sql = "SELECT COUNT(*) AS count FROM Write_Review WHERE GameGameID = '$game_id'";
    $result = mysqli_query($conn, $sql);		
    $total = mysqli_fetch_assoc($result);
    $count = $total['count'];
    $sql = "SELECT Rating FROM Game WHERE GameID = '$game_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $rating = $row['Rating'];
    $newrating = ($rating*($count-1) + $post_rate) / $count;
    $sql = "UPDATE Game SET Rating = '$newrating' WHERE GameID = '$game_id';";
    $result = mysqli_query($conn, $sql);
    header("Location: ../~$dbusername/game.php?GameID=$game_id");
  }
  else{
    header("Location: ../~$dbusername/store.php");
  }
}
else{
  header("Location: ../~$dbusername/game.php?GameID=$game_id");
}
?>