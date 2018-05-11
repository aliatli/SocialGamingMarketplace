<?php
session_start();
include_once 'config.php';

if(isset($_SESSION['UserID'])){
  $user_id = $_SESSION['UserID'];
  
  //Recommended game
  $sql_rec = "SELECT GameGameID, count(*) AS Count FROM Buy GROUP BY GameGameID ORDER BY count(*) DESC LIMIT 1;";
  $result_rec = mysqli_query($conn, $sql_rec);
  $result_rec_check = mysqli_num_rows($result_rec);

  if($result_rec_check === 0){
    $sql_rec = "SELECT GameID FROM Game ORDER BY RAND() LIMIT 1;";
    $result_rec = mysqli_query($conn, $sql_rec);
    $result_rec_check = mysqli_num_rows($result_rec);
    if($result_rec_check === 0){
      header("Location: ../~$dbusername/register_login.php");
      exit();
    }
    else{
      if($row = mysqli_fetch_assoc($result_rec)){
        $rec_id = $row['GameID'];
      }
    }
  }
  else{
    if($row = mysqli_fetch_assoc($result_rec)){
      $rec_id = $row['GameGameID'];
    }
  }
  
  $sql_get_rec = "SELECT * FROM Game WHERE GameID = '$rec_id';";
  $result_get_rec = mysqli_query($conn, $sql_get_rec);

  if($row = mysqli_fetch_assoc($result_get_rec)){
    $rec_name = $row['Name'];
    $rec_restrict = $row['AgeRestriction'];
    $rec_price = $row['Price'];
    $rec_rating = $row['Rating'];
    $rec_no_player = $row['NumberOfPlayers'];
    $rec_sys_req = $row['SystemRequirements'];
    $rec_info = $row['Info'];
  }
}
else{
  header("Location: ../~$dbusername/register_login.php");
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
      min-width: 70px;
      min-height: 70px;
    }

    .button-wrapper .btn {
      margin-top: 3%;
    }

    a {
      text-decoration: none !important;
    }

    a:hover {
      //color: blue;
      cursor: pointer;
    }

    </style>

    <title>Store</title>
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
                    <div class="panel panel-default" style="margin-top: 3%; min-width: 100px;">
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
          <div class="row">
            <div class="col-md-9">
              <div class="panel panel-default">
                <div class="row">
                  <div class="col-md-5">
                    <img src="images/<?php echo $user_id ?>.jpg" class="img-responsive" alt="Image" style="border: 1px solid black; width: 100%; height: 47%">
                  </div>
                  <div class="col-md-7">
		  <!--
		    $rec_name = $row['Name'];
		    $rec_restrict = $row['AgeRestriction'];
		    $rec_price = $row['Price'];
		    $rec_rating = $row['Rating'];
		    $rec_no_player = $row['NumberOfPlayers'];
		    $rec_sys_req = $row['SystemRequirements'];
		    $rec_info = $row['Info'];
		  -->
                    <div class="col-md-11" style="border: 1px solid black; min-height: 10%; max-height: 29%">
		      <a href="/~<?php echo $dbusername?>/game.php?<?php echo $rec_id?>">
                        <p class="text-center" style="font-size:300%">
		          <?php echo $rec_name ?>
		        </p>
		      </a>
                    </div>
                    <div class="col-md-11" style="min-height: 10%; max-height: 29%">
		      <div class="row">
                        <div class="col-md-6" style="border: 1px solid black;margin-top: 3%; min-height: 15%">
                          <p class="text" style="font-size:150%">
		            Age Restriction: <?php echo $rec_restrict ?>
		          </p>
			  <br></br>
                          <p class="text" style="font-size:150%">
			    Price: $<?php echo $rec_price ?>
		          </p>
                        </div>
                        <div class="col-md-6" style="border: 1px solid black;margin-top: 3%; min-height: 15%">
                          <p class="text" style="font-size:150%">
			    Rating: <?php echo $rec_rating ?>
		          </p>
			  <br></br>
                          <p class="text" style="font-size:150%">
			    Number of Players: <?php echo $rec_no_player ?>
		          </p>
                        </div>
		      </div>
		    </div>
                    <div class="col-md-11" style="margin-top: 3%; min-height: 17%; max-height: 29%">
		      <div class="row">
                        <div class="col-md-6" style="border: 1px solid black; min-height: 17%; max-height: 29%">
                          <p class="text" style="font-size:100%">
		            System Requirements: <?php echo $rec_sys_req ?>
		          </p>
                        </div>
                        <div class="col-md-6" style="border: 1px solid black; min-height: 17%; max-height: 29%">
                          <p class="text" style="font-size:100%">
			    Info: <?php echo $rec_info ?>
		          </p>
                        </div>
		      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 button-wrapper btn">
              <button type="button" class="btn btn-primary" style="margin-top: 0%">
                <p class="text" style="font-size:300%">Genre 1</p>
              </button>
              <button type="button" class="btn btn-primary">
                <p class="text" style="font-size:300%">Genre 2</p>
              </button>
              <button type="button" class="btn btn-primary">
                <p class="text" style="font-size:300%">Genre 3</p>
              </button>
              <button type="button" class="btn btn-primary">
                <p class="text" style="font-size:300%">Genre 4</p>
              </button>
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
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-3">
                <div class="panel panel-default" style="display: flex-start;justify-content: center;align-items: center;">
                  <button class="btn btn-primary" onclick="best_rating()">
                    <p class="text" style="font-size:100%">List By Rating</p>
                  </button>
                </div>
              </div>
              <div class="col-md-1"></div>
              <div class="col-md-4">
                <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
                  <button class="btn btn-primary" onclick="lowest_price()">
                    <p class="text" style="font-size:100%">List By Lowest Price</p>
                  </button>
                </div>
              </div>
              <div class="col-md-1"></div>
              <div class="col-md-3">
                <div class="panel panel-default" style="display: flex-end;justify-content: center;align-items: center">
                  <button class="btn btn-primary" onclick="asc_title();">
                    <p class="text" style="font-size:100%">List By Title</p>
                  </button>
                </div>
              </div>
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
          <div id="best_rating">
            <div class="col-md-9" style="border: 1px solid black">
              <p class="text" style="font-size:300%">SQL 1</p>
            </div>
          </div>

          <div id="lowest_price" style="display:none">
            <div class="col-md-9" style="border: 1px solid black">
              <p class="text" style="font-size:300%">SQL 2</p>
            </div>
          </div>

          <div id="asc_title" style="display:none">
            <div class="col-md-9" style="border: 1px solid black">
              <p class="text" style="font-size:300%">SQL 3</p>
            </div>
          </div>
        </div>
        <div class="col-md-1"></div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <script language="JavaScript" type="text/javascript">
    function best_rating(){
      var best_rating = document.getElementById("best_rating");
      var lowest_price = document.getElementById("lowest_price");
      var asc_title = document.getElementById("asc_title");
      best_rating.style.display = "block";
      lowest_price.style.display = "none";
      asc_title.style.display = "none";
    }

    function lowest_price(){
      var best_rating = document.getElementById("best_rating");
      var lowest_price = document.getElementById("lowest_price");
      var asc_title = document.getElementById("asc_title");
      best_rating.style.display = "none";
      lowest_price.style.display = "block";
      asc_title.style.display = "none";
    }

    function asc_title(){
      var best_rating = document.getElementById("best_rating");
      var lowest_price = document.getElementById("lowest_price");
      var asc_title = document.getElementById("asc_title");
      best_rating.style.display = "none";
      lowest_price.style.display = "none";
      asc_title.style.display = "block";
    }
    </script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>
