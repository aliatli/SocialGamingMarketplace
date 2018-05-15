<?php
session_start();
include_once 'config.php';

if(isset($_SESSION['UserID'])){
  if(isset($_POST['GameID'])){
    $user_id = $_SESSION['UserID'];
    $game_id = $_POST['GameID'];

    $sql = "SELECT Balance FROM User WHERE UserID = $user_id";
    $result = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_assoc($result)){
      $balance = $row['Balance'];
    }

    $sql = "SELECT Price FROM Game WHERE GameID = $game_id";
    $result = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_assoc($result)){
      $price = $row['Price'];
    }

    if(isset($_POST['discount_balance'])){
      $discount_balance = $_POST['discount_balance'];
    }

    $sql_discount = "SELECT * FROM Inventory, Discount_Card WHERE Discount_Card.ItemID = Inventory.ItemItemID AND Inventory.ItemItemID IN (SELECT Item.ItemID FROM Item, Discount_Card WHERE Item.ItemID = Discount_Card.ItemID AND Code = '$discount_balance' AND Item.GameGameID = $game_id);";
    $result_discount = mysqli_query($conn, $sql_discount);
    $result_discount_check = mysqli_num_rows($result_discount);

    if($result_discount_check === 1){
      if($row = mysqli_fetch_assoc($result_discount)){
        $discount_rate = $row['DiscountRate'];
	$price = $price / $discount_rate;
	$discount_id = $row['ItemID'];
      }
    }
      
    if($price <= $balance){
      $sql = "INSERT INTO Buy (UserUserID, GameGameID) VALUES($user_id, $game_id)";
      $result = mysqli_query($conn, $sql);

      $newbalance = ((double)$balance) - ((double)$price);

      $sql = "UPDATE User SET Balance = '$newbalance' WHERE UserID = $user_id";
      $result = mysqli_query($conn, $sql);

$sql_delete = "DELETE FROM Item WHERE ItemID = $discount_id;";
mysqli_query($conn, $sql_delete);
$sql_delete = "DELETE FROM Inventory WHERE ItemItemID = $discount_id;";
mysqli_query($conn, $sql_delete);

    }
  
    header("Location: ../~$dbusername/game.php?GameID=$game_id");
    exit();
  }
  else if(isset($_POST['GameIDCard'])){
    $user_id = $_SESSION['UserID'];
    $game_id = $_POST['GameIDCard'];
    $sql = "SELECT CardNo, Cvv, BillingAddress FROM User WHERE UserID = $user_id;";
    $result = mysqli_query($conn, $sql);
    $row_no = mysqli_num_rows($result);

    if(isset($_POST['discount_credit'])){
      $discount_credit = $_POST['discount_credit'];
    }

    $sql_discount = "SELECT * FROM Inventory, Discount_Card WHERE Discount_Card.ItemID = Inventory.ItemItemID AND Inventory.ItemItemID IN (SELECT Item.ItemID FROM Item, Discount_Card WHERE Item.ItemID = Discount_Card.ItemID AND Code = '$discount_credit' AND Item.GameGameID = $game_id);";
    $result_discount = mysqli_query($conn, $sql_discount);
    $result_discount_check = mysqli_num_rows($result_discount);

    if($result_discount_check === 1){
      if($row = mysqli_fetch_assoc($result_discount)){
	$discount_id = $row['ItemID'];
      }
    }

    if($row_no !== 0){
      if($row = mysqli_fetch_assoc($result)){
	if(is_null($row['Cvv']) || is_null($row['CardNo']) || is_null($row[BillingAddress])){
          header("Location: ../~$dbusername/game.php?GameID=$game_id");
          exit();
        }
	else{
	  $sql = "INSERT INTO Buy VALUES ($user_id, $game_id);";
          $result = mysqli_query($conn, $sql);

$sql_delete = "DELETE FROM Item WHERE ItemID = $discount_id;";
mysqli_query($conn, $sql_delete);
$sql_delete = "DELETE FROM Inventory WHERE ItemItemID = $discount_id;";
mysqli_query($conn, $sql_delete);

          header("Location: ../~$dbusername/game.php?GameID=$game_id");
          exit();
	}
      }
    }
    else{
      header("Location: ../~$dbusername/game.php?GameID=$game_id");
      exit();
    }
  }
}
else{
  header("Location: ../~$dbusername/game.php?GameID=$game_id");
  exit();
}
?>
