<?php
session_start();
include_once 'config.php';
if(isset($_SESSION['UserID'])){
  $user_id = $_SESSION['UserID'];
 
  $sql_user = "SELECT UserName FROM User Where UserID = $user_id;";
  $result_user = mysqli_query($conn, $sql_user);
  $result_user_check = mysqli_num_rows($result_user);
  if($row = mysqli_fetch_assoc($result_user)){
    $rec_userName = $row['UserName'];
  }
      //in game item
  $sql_in_game_page = "SELECT Item.Name,Price,Item.Info FROM In_Game_Item NATURAL JOIN Item WHERE ItemID IN (SELECT ItemItemID FROM Inventory WHERE UserUserID = $user_id) ORDER BY Name ASC;";
  $result_page_in_game = mysqli_query($conn, $sql_in_game_page);
  $result_page_check_in_game = mysqli_num_rows($result_page_in_game);
  
    //discount card
  $sql_discount_page = "SELECT Item.Name,DiscountRate,Item.Info FROM Discount_Card NATURAL JOIN Item WHERE ItemID IN (SELECT ItemItemID FROM Inventory WHERE UserUserID = $user_id) ORDER BY Name ASC;";
  $result_page_discount = mysqli_query($conn, $sql_discount_page);
  $result_page_check_discount = mysqli_num_rows($result_page_discount);
      if($result_page_check_discount == 0){
        //header("Location: ../~$dbusername/profile.php");
         //exit();
      }
       
      if($result_page_check_in_game == 0){
        //header("Location: ../~$dbusername/profile.php");
         //exit();
      }
      
     //---------------------------------------------------------------------------------------------------------------------------------------
       if(!isset($_GET['page_in_game']))
       {
      header("Location: ../~$dbusername/inventory.php?UserID=$user_id&page_in_game=1");
      exit();
        }
  else
  {
      $page_in_game = $_GET['page_in_game'];
      if(!isset($_GET['page_discount']))
      {
        header("Location: ../~$dbusername/inventory.php?UserID=$user_id&page_in_game=$page_in_game&page_discount=1");
        exit();
      }
      else
      {
        $page_discount = $_GET['page_discount'];
      }
  }
    //----------------------------------------------------------------------------------------------------------------------------------------
         //Number of pages in game item
          $result_per_page_in_game = 5;
          $number_of_pages_in_game = ceil($result_page_check_in_game / $result_per_page_in_game);
       
        $page_in_game = $_GET['page_in_game'];
      if($page_in_game > $number_of_pages_in_game + 1 || $page_in_game < 1){
        header("Location: ../~$dbusername/inventory.php?UserID=$user_id&page_in_game=1&page_discount=1");
      exit();
      }
      //Display via pagination
    $starting_limit_index_in_game = ($page_in_game - 1) * 5;
    $sql_in_game = "SELECT Item.Name,Price,Item.Info FROM In_Game_Item NATURAL JOIN Item WHERE ItemID IN (SELECT ItemItemID FROM Inventory WHERE UserUserID = $user_id) ORDER BY Name ASC LIMIT " . $starting_limit_index_in_game . ", 5";
    $result_in_game = mysqli_query($conn, $sql_in_game);
//-----------------------------------------------------------------------------------------------------------------------------------------------------
    //discount card
     $result_per_page_discount = 5;
    $number_of_pages_discount = ceil($result_page_check_discount / $result_per_page_discount);
      $page_discount = $_GET['page_discount'];
      if($page_discount > $number_of_pages_discount + 1 || $page_discount < 1){
        header("Location: ../~$dbusername/inventory.php?UserID=$user_id&page_in_game=1&page_discount=1");
      exit();
      }
    $starting_limit_index_discount = ($page_discount - 1) * 5;
   $sql_discount = "SELECT Item.Name,DiscountRate,Item.Info FROM Discount_Card NATURAL JOIN Item WHERE ItemID IN (SELECT ItemItemID FROM Inventory WHERE UserUserID = $user_id) ORDER BY Name ASC LIMIT " . $starting_limit_index_discount . ", 5";
   $result_discount = mysqli_query($conn,$sql_discount);
     
}
else{
  header("Location: ../~$dbusername/profile.php");
  exit();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!--
      <link rel="stylesheet" href="/Css/store.css">
    -->
    <style>
    .container-fluid {
      margin-top: 25px;
    }
    .text {
      word-wrap: break-word;
    }
    .btn{
        text-align: center;
        white-space: normal;
        word-wrap: break-word;
        width: 100%;
    }
    .button-wrapper .btn {
      margin-top: 3%;
    }
    .img-responsive{
      max-width: 100%;
      max-height: 100%;
    }
    </style>

    <title>Inventory</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <div class="row">
            <div class="col-md-3">
              <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
                <button type="button" class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/store.php'">
                  <p class="text" style="font-size:300%">Store</p> 
                </button>
              </div>
            </div>
            <div class="col-md-3">
              <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
                <button type="button" class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/profile.php?<?php echo $userid ?>'">
                  <p class="text" style="font-size:300%">Profile</p>
                </button>
              </div>
            </div>
            <div class="col-md-3">
              <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
                <button type="button" class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/community.php'">
                  <p class="text" style="font-size:300%">Community</p>
                </button>
              </div>
            </div>
            <div class="col-md-3">
	      <form class="form" role="form" method="post" action="/~<?php echo $dbusername ?>/search.php">
              <div class="row">
                <div class="col-md-9">
                  <div class="panel panel-default" style="margin-top: 3%">
                    <input class="form-control" placeholder="Search" style="font-size:300%" name="search_content">
                  </div>
                </div>
                <div class="col-md-3" style="margin-top: 5%">
                  <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search" style="font-size:300%"></i>
                  </button>
                </div>
              </div>
	      </form>
            </div>
          </div>
        </div>
        <div class="col-md-1"></div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <p class="text-center" style="font-size:300%">Inventory of <?php echo $rec_userName ?> </p>
        </div>
        <div class="col-md-1"></div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-5">
          <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
            <div class="col-md-12" style="border: 1px solid black">
              <div class="norow">
                <p class="text-center" style="font-size:200%">Ingame Items</p>
                    <?php
                    while($row = mysqli_fetch_assoc($result_in_game)){
			echo '<div class="row">';
			  echo '<div class="col-md-4">';
                          echo '<p class="text-left" style="font-size:150%">';
                          echo $row['Name'];
		          echo '</p>';
			  echo '</div>';
			  echo '<div class="col-md-4">';
                          echo '<p class="text-center" style="font-size:150%">';
                          echo $row['Price'];
		          echo '</p>';
			  echo '</div>';
			  echo '<div class="col-md-4">';
                          echo '<p class="text-right" style="font-size:150%">';
                          echo $row['Info'];
		          echo '</p>';
			  echo '</div>';
			echo '</div>';
                    }
               
               echo '<nav aria-label="Page navigation example">';
                echo '<ul class="pagination justify-content-center">';
                  if($_GET['page_in_game'] <= 1){
                    $disabled = " disabled";
                  }
                  else{
                    $disabled = "";
                  }
                    $page_pre = $page_in_game - 1;
                    $page_post = $page_in_game + 1;
                    
                    echo '<li class="page-item' .  $disabled . '">';
                      echo '<a class="page-link" href="/~' . $dbusername . '/inventory.php?UserID=' . $user_id . '&page_in_game=' . $page_pre . '&page_discount=' . $page_discount . '">Previous</a>'; 
                    echo '</li>';
                     for($page = 1; $page <= $number_of_pages_in_game; $page++){
                        if($page == $_GET['page_in_game']){
                          $disabled = " disabled";
                        }
                        else{
                          $disabled = "";
                        }
                   
                        echo '<li class="page-item' . $disabled . '">';
                        echo '<a class="page-link" href="/~' . $dbusername . '/inventory.php?UserID=' . $user_id .'&page_in_game=' . $page . '&page_discount=' . $page_discount . '">' . $page . '</a>';
                        echo '</li>';
                    }
                    if($_GET['page_in_game'] >= $number_of_pages_in_game){
                        $disabled = " disabled";
                    }
                    else{
                        $disabled = "";
                    }
                      echo '<li class="page-item' . $disabled . '">';
                      echo '<a class="page-link" href="/~' . $dbusername . '/inventory.php?UserID=' . $user_id .'&page_in_game=' . $page_post . '&page_discount=' . $page_discount . '">Next</a>';
                    echo '</li>';
                  echo '</ul>';
                echo '</nav>';
                  ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
            <div class="col-md-12" style="border: 1px solid black">
              <div class="norow">
                <p class="text-center" style="font-size:200%">Discount Cards</p>
                      <?php
                      while($row = mysqli_fetch_assoc($result_discount)){
			echo '<div class="row">';
			  echo '<div class="col-md-4">';
                          echo '<p class="text-left" style="font-size:150%">';
                          echo $row['Name'];
		          echo '</p>';
			  echo '</div>';
			  echo '<div class="col-md-4">';
                          echo '<p class="text-center" style="font-size:150%">';
                          echo $row['DiscountRate'];
		          echo '</p>';
			  echo '</div>';
			  echo '<div class="col-md-4">';
                          echo '<p class="text-right" style="font-size:150%">';
                          echo $row['Info'];
		          echo '</p>';
			  echo '</div>';
			echo '</div>';
                         }
                         echo '<nav aria-label="Page navigation example">';
                echo '<ul class="pagination justify-content-center">';
                    if($_GET['page_discount'] <= 1){
                        $disabled = " disabled";
                    }
                    else{
                      $disabled = "";
                    }
                    $page_pre = $page_discount - 1;
                    $page_post = $page_discount + 1;
                      echo '<li class="page-item' .  $disabled . '">';
                      echo '<a class="page-link" href="/~' . $dbusername . '/inventory.php?UserID=' . $user_id . '&page_in_game=' . $page_in_game . '&page_discount=' . $page_pre . '">Previous</a>'; 
                    echo '</li>';
                    for($page = 1; $page <= $number_of_pages_discount; $page++){
                        if($page == $_GET['page_discount']){
                          $disabled = " disabled";
                        }
                        else{
                          $disabled = "";
                        }
                   
                        echo '<li class="page-item' . $disabled . '">';
                        echo '<a class="page-link" href="/~' . $dbusername . '/inventory.php?UserID=' . $user_id .'&page_in_game=' . $page_in_game . '&page_discount=' . $page . '">' . $page . '</a>';
                        echo '</li>';
                    }
                    if($_GET['page_discount'] >= $number_of_pages_discount){
                        $disabled = " disabled";
                    }
                    else{
                       $disabled = "";
                    }
                       echo '<li class="page-item' . $disabled . '">';
                      echo '<a class="page-link" href="/~' . $dbusername . '/inventory.php?UserID=' . $user_id .'&page_in_game=' . $page_in_game . '&page_discount=' . $page_post . '">Next</a>';
                    echo '</li>';
                  echo '</ul>';
                echo '</nav>';
                      ?>
              </div>
            </div>
          </div>
        </div>
        <div clas="col-md-1"></div>
      </div>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html> 