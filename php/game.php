<?php
session_start();
include_once 'config.php';

if(isset($_GET['GameID'])){
  $game_id = $_GET['GameID'];
  $sql_rec = "SELECT * FROM Game WHERE GameID = '$game_id';";
  $user_id = $_SESSION['UserID'];
  $result_get_rec = mysqli_query($conn, $sql_rec);

  $_SESSION['UserID'] = $user_id;
  $_SESSION['GameID'] = $game_id;
  if($row = mysqli_fetch_assoc($result_get_rec)){
    $rec_name = $row['Name'];
    $rec_restrict = $row['AgeRestriction'];
    $rec_price = $row['Price'];
    $rec_rating = $row['Rating'];
    $rec_no_player = $row['NumberOfPlayers'];
    $rec_sys_req = $row['SystemRequirements'];
    $rec_info = $row['Info'];
  }
  //Number of pages
  $sql_page = "SELECT Comment, Rating, UserUserID FROM Write_Review ORDER BY Rating DESC";
  $result_page = mysqli_query($conn, $sql_page);
  $result_page_check = mysqli_num_rows($result_page);
  if($result_page_check == 0){
    header("Location: ../~$dbusername/gamenoreview.php");
    exit();
  }
  $result_per_page = 3;
  $number_of_pages = ceil($result_page_check / $result_per_page);
  if(!isset($_GET['page'])){
    $page = 1;
    header("Location: ../~$dbusername/game.php?GameID=$game_id&page=1");
    exit();
  }
  else{
    $page = $_GET['page'];
  }
  if($page > $number_of_pages || $page < 1){
    header("Location: ../~$dbusername/game.php?GameID=$game_id&page=1");
    exit();
  }
  //Display via pagination
  $starting_limit_index = ($page - 1) * 3;
  $sql_rating = "SELECT Comment, Rating, UserUserID FROM Write_Review ORDER BY Rating DESC LIMIT " . $starting_limit_index . ", 3";
  $result_rating = mysqli_query($conn, $sql_rating);
  
}
else{
  header("Location: ../~$dbusername/store.php");
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
        white-space:normal;
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

    .rating {
      border: none;
      float: left;
    }

    .rating > input {
      display: none;
    }

    .rating > label:before {
      margin: 5px;
      font-size: 1.25em;
      font-family: FontAwesome;
      display: inline-block;
      content: "\f005";
    }

    .rating > label {
      color: #ddd;
      float: right;
    }

    .rating > input:checked ~ label,
    .rating:not(:checked) > label:hover,
    .rating:not(:checked) > label:hover ~ label { color: #FFD700;  }

    .rating > input:checked + label:hover,
    .rating > input:checked ~ label:hover,
    .rating > label:hover ~ input:checked ~ label,
    .rating > input:checked ~ label:hover ~ label { color: #FFED85;  }

    </style>

    <title>Game</title>
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
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="row">
                  <div class="col-md-6">
                    <img src="images/<?php echo $game_id ?>.jpg" class="img-responsive" alt="Image" style="border: 1px solid black; width: 100%; height: 47%">
                    <!--
                      Must be bigger than container!
                      Must be square!
                    -->
                  </div>
                  <div class="col-md-6">
                    <div class="col-md-12" style="border: 1px solid black;margin-top: 3%; min-height: 29%; max-height: 29%">
                      <p class="text" style="font-size:300%"> <?php echo $rec_name ?></p>
		      <p class="text" style="font-size:200%"> Price: $<?php echo $rec_price ?></p>
		      <p class="text" style="font-size:200%"> Rating: <?php echo $rec_rating ?>/5 </p>
                    </div>
                    <div class="col-md-12" style="border: 1px solid black;margin-top: 3%; min-height: 29%; max-height: 29%">
                      <p class="text" style="font-size:90%"> Game Description: <?php echo $rec_info ?></p>
                    </div>
                    <div class="col-md-12" style="border: 1px solid black;margin-top: 3%; min-height: 29%; max-height: 29%">
                      <p class="text" style="font-size:100%"> System Requirements: <?php echo $rec_sys_req ?></p>
	              <p class="text" style="font-size:100%"> Number of Players: <?php echo $rec_no_player ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2"></div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="row">
                  <div class="col-md-2">
                    <div class="panel panel-default" style="display: flex-end;justify-content: center;align-items: center">
		      <form role="form" method="post" action="/~<?php echo $dbusername ?>/addwishlist.php">
                        <button class="btn btn-primary" name = "GameID" value = "<?php echo $game_id?>">
                          <p class="text" style="font-size:100%">Add Wishlist</p>
                        </button>
		      </form>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <label for="discount_card_no" class="col-md-12 col-form-label" style="font-size:100%; margin-top: 3%">Discount Card No:</label>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group required">
                      <div class="col-md-12">
                        <input class="form-control" style="font-size:100%; margin-top: 3%" type="text" value="" id="discount_card_no" maxlength="20" placeholder="Discount Card No">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="panel panel-default" style="display: flex-end;justify-content: center;align-items: center">
                      <form role="form" method="post" action="/~<?php echo $dbusername ?>/buy.php">
                        <button class="btn btn-primary" name = "GameIDCard" value = "<?php echo $game_id?>">
                          <p class="text" style="font-size:100%">Buy With Card</p>
                        </button>
                      </form>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="panel panel-default" style="display: flex-end;justify-content: center;align-items: center">
		      <form role="form" method="post" action="/~<?php echo $dbusername ?>/buy.php">
                        <button class="btn btn-primary" name = "GameID" value = "<?php echo $game_id?>">
                          <p class="text" style="font-size:100%">Buy With Balance</p>
                        </button>
		      </form>
                      <button class="btn btn-primary" style="display:none">
                        <p class="text" style="font-size:100%">Download</p>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2"></div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
            <div class="col-md-12" style="border: 1px solid black">
              <div class="norow">
                <p class="text-center" style="font-size:200%">Reviews</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2"></div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div id="best_rating">
            <div class="col-md-12" style="border: 1px solid black">
	      <?php
		while($row = mysqli_fetch_assoc($result_rating)){
	          echo '<div class="row">';
		    echo '<div class="col-md-4">';
		      echo '<p class="text-left" style="font-size:150%">';
		      echo  $row['Comment'];
		      echo '</p>';
		    echo '</div>';
		    echo '<div class="col-md-4">';
		      echo '<p class="text-center" style="font-size:150%">';
		      echo  'Rating = ' .$row['Rating']. '/5' ;
		      echo '</p>';
		    echo '</div>';
	          echo '</div>';
		}
		echo '<nav aria-label="Page navigation example">';
		  echo '<ul class="pagination justify-content-center">';
		    if($_GET['page'] <= 1){
		      $disabled = " disabled";
		    }
		    else{
		      $disabled = "";
		    }
		    
		    $page_pre = $page - 1;
		    $page_post = $page + 1;
		    echo '<li class="page-item' . $disabled . '">';
		      echo '<a class="page-link" href="/~' . $dbusername . '/game.php?GameID=' . $game_id .'&page=' . $page_pre . '">Previous</a>';
		    echo '</li>';
		    for($page = 1; $page <= $number_of_pages; $page++){
		      if($page == $_GET['page']){
			$disabled = " disabled";
		      }
		      else{
			$disabled = "";
		      }
		      echo '<li class="page-item' . $disabled . '">';
		        echo '<a class="page-link" href="/~' . $dbusername . '/game.php?GameID=' . $game_id .'&page=' .$page . '">' . $page . '</a>';
		      echo '</li>';
		    }
		    if($_GET['page'] >= $number_of_pages){
		      $disabled = " disabled";
		    }
		    else{
		      $disabled = "";
		    }
		    echo '<li class="page-item' . $disabled . '">';
                      echo '<a class="page-link" href="/~' . $dbusername . '/game.php?GameID=' . $game_id .'&page=' . $page_post . '">Next</a>';
		    echo '</li>';
		  echo '</ul>';
		echo '</nav>';
	      ?>
            </div>
          </div>
        </div>
        <div class="col-md-1"></div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
	 <form class="form" role="form" method="post" action="/~<?php echo $dbusername ?>/review.php">
          <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
            <div class="col-md-12" style="border: 1px solid black">
              <div class="form-group required">
                <label for="write_review" class="col-md-12 col-form-label" style="font-size:120%">Write review:</label>
                <div class="col-md-12">
                  <input class="form-control" placeholder="Write review" rows="3" style="font-size:100%" name="comment">
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-2" style="margin-left: 1%">
                    <fieldset class="rating">
                        <input type="radio" id="star1" name="rating" value="5" /><label class="full" for="star1"></label>
                        <input type="radio" id="star2" name="rating" value="4" /><label class="full" for="star2"></label>
                        <input type="radio" id="star3" name="rating" value="3" /><label class="half" for="star3"></label>
                        <input type="radio" id="star4" name="rating" value="2" /><label class="full" for="star4"></label>
                        <input type="radio" id="star5" name="rating" value="1" /><label class="half" for="star5"></label>
                    </fieldset>
                  </div>
                  <div class="col-md-7"></div>
                  <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" style="margin-left: 45%" name = "GameID" value = "<?php echo $game_id?>">Post</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
         </form>
        </div>
        <div class="col-md-2"></div>
      </div>
    </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>
