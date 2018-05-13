<?php
session_start();
include_once 'config.php';
if(isset($_SESSION['UserID'])){
  $user_id = $_SESSION['UserID'];


  if(!isset($_GET['page'])){
    header("Location: ../~$dbusername/genre.php?page=1&content=best_rating&type=$type");
    exit();
  }
  else{
    $page = $_GET['page'];
    if(!isset($_GET['type'])){
      $sql_get_type = "SELECT * FROM Genre LIMIT 1;";
      $result_get_type = mysqli_query($conn, $sql_get_type);
      $result_get_type_check = mysqli_num_rows($result_get_type);

      if($result_get_type_check === 0){
        header("Location: ../~$dbusername/store.php?page=1&content=best_rating");
        exit();
      }
      else{
        if($row = mysqli_fetch_assoc($result_get_type)){
          $type = $row['Type'];
	  header("Location: ../~$dbusername/genre.php?page=$page&content=best_rating&type=$type");
	  exit();
        }
      }
    }
    else{
      $type = $_GET['type'];
      $sql_get_type = "SELECT * FROM Genre WHERE Type = '$type';";
      $result_get_type = mysqli_query($conn, $sql_get_type);
      $result_get_type_check = mysqli_num_rows($result_get_type);

      if($result_get_type_check === 0){
        header("Location: ../~$dbusername/store.php?page=1&content=best_rating");
        exit();
      }
      else{
        if(!isset($_GET['content'])){
          header("Location: ../~$dbusername/genre.php?page=$page&content=best_rating&type=$type");
	  exit();
        }
        else{
          $content = $_GET['content'];
        }
      }
    }
  }

  //Recommended game
  $sql_rec = "SELECT GameGameID, count(*) AS Count FROM Buy WHERE GameGameID IN (SELECT GameGameID FROM Belong, Genre WHERE Belong.GenreGenreID = Genre.GenreID AND Genre.Type = '$type') GROUP BY GameGameID ORDER BY count(*) DESC LIMIT 1;";
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

  if($_GET['content'] === best_rating){
    $sql_page = "SELECT Name, Rating, Price FROM Game WHERE GameID IN (SELECT GameGameID FROM Belong, Genre WHERE Belong.GenreGenreID = Genre.GenreID AND Genre.Type = '$type') ORDER BY Rating DESC;";
  }
  else if($_GET['content'] === lowest_price){
    $sql_page = "SELECT Name, Rating, Price FROM Game WHERE GameID IN (SELECT GameGameID FROM Belong, Genre WHERE Belong.GenreGenreID = Genre.GenreID AND Genre.Type = '$type') ORDER BY Price ASC;";
  }
  else if($_GET['content'] === title){
    $sql_page = "SELECT Name, Rating, Price FROM Game WHERE GameID IN (SELECT GameGameID FROM Belong, Genre WHERE Belong.GenreGenreID = Genre.GenreID AND Genre.Type = '$type') ORDER BY Name ASC;";
  }

  $result_page = mysqli_query($conn, $sql_page);
  $result_page_check = mysqli_num_rows($result_page);
  $result_per_page = 5;
  $number_of_pages = ceil($result_page_check / $result_per_page);

  $page = $_GET['page'];

  if($page > $number_of_pages || $page < 1){
    header("Location: ../~$dbusername/genre.php?page=1");
    exit();
  }

  //Display via pagination
  $starting_limit_index = ($page - 1) * 5;

  if($_GET['content'] === best_rating){
    $sql_rating = "SELECT Name, Rating, Price FROM Game WHERE GameID IN (SELECT GameGameID FROM Belong, Genre WHERE Belong.GenreGenreID = Genre.GenreID AND Genre.Type = '$type') ORDER BY Rating DESC LIMIT " . $starting_limit_index . ", 5;";
  }
  else if($_GET['content'] === lowest_price){
    $sql_rating = "SELECT Name, Rating, Price FROM Game WHERE GameID IN (SELECT GameGameID FROM Belong, Genre WHERE Belong.GenreGenreID = Genre.GenreID AND Genre.Type = '$type') ORDER BY Price ASC LIMIT " . $starting_limit_index . ", 5;";
  }
  else if($_GET['content'] === title){
    $sql_rating = "SELECT Name, Rating, Price FROM Game WHERE GameID IN (SELECT GameGameID FROM Belong, Genre WHERE Belong.GenreGenreID = Genre.GenreID AND Genre.Type = '$type') ORDER BY Name ASC LIMIT " . $starting_limit_index . ", 5;";
  }

  $result_rating = mysqli_query($conn, $sql_rating);

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

    <title>Genre</title>
  </head>
  <body>
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
                <button type="button" class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/profile.php?profile_no<?php echo $user_id ?>'">
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
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="row">
                  <div class="col-md-6">
                    <img src="images/<?php echo $user_id ?>.jpg" class="img-responsive" alt="Image" style="border: 1px solid black; width: 100%; height: 47%">
                  </div>
                  <div class="col-md-6">
		  <!--
		    $rec_name = $row['Name'];
		    $rec_restrict = $row['AgeRestriction'];
		    $rec_price = $row['Price'];
		    $rec_rating = $row['Rating'];
		    $rec_no_player = $row['NumberOfPlayers'];
		    $rec_sys_req = $row['SystemRequirements'];
		    $rec_info = $row['Info'];
		  -->
                    <div class="col-md-12" style="border: 1px solid black; min-height: 10%; max-height: 29%">
		      <a href="/~<?php echo $dbusername?>/game.php?GameID=<?php echo $rec_id?>">
                        <p class="text-center" style="font-size:300%">
		          <?php echo $rec_name ?>
		        </p>
		      </a>
                    </div>
                    <div class="col-md-12" style="min-height: 10%; max-height: 29%">
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
                    <div class="col-md-12" style="margin-top: 3%; min-height: 17%; max-height: 29%">
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
          <div class="col-md-12">
            <div class="row">
	      <div class="col-md-1"></div>
	      <div class="col-md-10">
		<div class="row">
                  <div class="col-md-3">
                    <div class="panel panel-default">
                      <button class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/genre.php?page=<?php echo $_GET['page'] ?>&content=best_rating&type=<?php echo $_GET['type'] ?>'">
                        <p class="text" style="font-size:100%">List By Rating</p>
                      </button>
                    </div>
                  </div>
                  <div class="col-md-1"></div>
                  <div class="col-md-4">
                    <div class="panel panel-default">
                      <button class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/genre.php?page=<?php echo $_GET['page'] ?>&content=lowest_price&type=<?php echo $_GET['type'] ?>'">
                        <p class="text" style="font-size:100%">List By Lowest Price</p>
                      </button>
                    </div>
                  </div>
                  <div class="col-md-1"></div>
                  <div class="col-md-3">
                    <div class="panel panel-default">
                      <button class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/genre.php?page=<?php echo $_GET['page'] ?>&content=title&type=<?php echo $_GET['type'] ?>'">
                        <p class="text" style="font-size:100%">List By Title</p>
                      </button>
                    </div>
                  </div>
		</div>
	      </div>
	      <div class="col-md-1"></div>
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
	  <?php
	    if($_GET['content'] !== best_rating){
	      $disabled = True;
	    }
	    else{
	      $disabled = False;
	    }
	  ?>
	  <div class="col-md-12" style="border: 1px solid black">
	    <div class="row">
	      <div class="col-md-4">
	        <p class="text-left" style="font-size:200%">Name</p>
	      </div>
	      <div class="col-md-4">
	        <p class="text-center" style="font-size:200%">Rating</p>
	      </div>
	      <div class="col-md-4">
	        <p class="text-right" style="font-size:200%">Price</p>
	      </div>
	    </div>
	  </div>
          <div id="best_rating">
	    <?php
	      if(!$disabled){
                echo '<div class="col-md-12" style="border: 1px solid black">';
		  while($row = mysqli_fetch_assoc($result_rating)){
	            echo '<div class="row">';
		      echo '<div class="col-md-4">';
		        echo '<p class="text-left" style="font-size:150%">';
		        echo  $row['Name'];
		      echo '</p>';
		      echo '</div>';
		      echo '<div class="col-md-4">';
		        echo '<p class="text-center" style="font-size:150%">';
		        echo  $row['Rating'];
		        echo '</p>';
		      echo '</div>';
		      echo '<div class="col-md-4">';
		        echo '<p class="text-right" style="font-size:150%">';
		        echo  '$' . $row['Price'];
		        echo '</p>';
		      echo '</div>';
	            echo '</div>';
		  }
		  echo '<nav aria-label="Page navigation example">';
		    echo '<ul class="pagination justify-content-center">';
		      if($_GET['page'] <= 1){
		        $disabled = " disabled";
		      }
		    
		      $page_pre = $page - 1;
		      $page_post = $page + 1;

		      echo '<li class="page-item' . $disabled . '">';
		        echo '<a class="page-link" href="/~' . $dbusername . '/genre.php?page=' . $page_pre . '&content=best_rating&type=' . $type .'">Previous</a>';
		      echo '</li>';
		      for($page = 1; $page <= $number_of_pages; $page++){
		        if($page == $_GET['page']){
			  $disabled = " disabled";
		        }
		        else{
			  $disabled = "";
		        }

		        echo '<li class="page-item' . $disabled . '">';
		          echo '<a class="page-link" href="/~' . $dbusername . '/genre.php?page=' .$page . '&content=best_rating&type=' . $type .'">' . $page . '</a>';
		        echo '</li>';
		      }

		      if($_GET['page'] >= $number_of_pages){
		        $disabled = " disabled";
		      }
		      else{
		        $disabled = "";
		      }

		      echo '<li class="page-item' . $disabled . '">';
                        echo '<a class="page-link" href="/~' . $dbusername . '/genre.php?page=' . $page_post . '&content=best_rating$type=' . $type . '">Next</a>';
		      echo '</li>';
		    echo '</ul>';
		  echo '</nav>';
		echo '</dib>';
	      }
	    ?>
          </div>

	  <?php
	    if($_GET['content'] !== lowest_price){
	      $disabled = True;
	    }
	    else{
	      $disabled = False;
	    }

	  ?>

          <div id="lowest_price">
	    <?php
	      if(!$disabled){
                echo '<div class="col-md-12" style="border: 1px solid black">';
		  while($row = mysqli_fetch_assoc($result_rating)){
	            echo '<div class="row">';
		      echo '<div class="col-md-4">';
		        echo '<p class="text-left" style="font-size:150%">';
		        echo  $row['Name'];
		      echo '</p>';
		      echo '</div>';
		      echo '<div class="col-md-4">';
		        echo '<p class="text-center" style="font-size:150%">';
		        echo  $row['Rating'];
		        echo '</p>';
		      echo '</div>';
		      echo '<div class="col-md-4">';
		        echo '<p class="text-right" style="font-size:150%">';
		        echo  '$' . $row['Price'];
		        echo '</p>';
		      echo '</div>';
	            echo '</div>';
		  }
		  echo '<nav aria-label="Page navigation example">';
		    echo '<ul class="pagination justify-content-center">';
		      if($_GET['page'] <= 1){
		        $disabled = " disabled";
		      }
		    
		      $page_pre = $page - 1;
		      $page_post = $page + 1;

		      echo '<li class="page-item' . $disabled . '">';
		        echo '<a class="page-link" href="/~' . $dbusername . '/store.php?page=' . $page_pre . '&content=lowest_price">Previous</a>';
		      echo '</li>';
		      for($page = 1; $page <= $number_of_pages; $page++){
		        if($page == $_GET['page']){
			  $disabled = " disabled";
		        }
		        else{
			  $disabled = "";
		        }

		        echo '<li class="page-item' . $disabled . '">';
		          echo '<a class="page-link" href="/~' . $dbusername . '/store.php?page=' .$page . '&content=lowest_price">' . $page . '</a>';
		        echo '</li>';
		      }

		      if($_GET['page'] >= $number_of_pages){
		        $disabled = " disabled";
		      }
		      else{
		        $disabled = "";
		      }

		      echo '<li class="page-item' . $disabled . '">';
                        echo '<a class="page-link" href="/~' . $dbusername . '/store.php?page=' . $page_post . '&content=lowest_price">Next</a>';
		      echo '</li>';
		    echo '</ul>';
		  echo '</nav>';
		echo '</dib>';
	      }
	    ?>
          </div>

	  <?php
	    if($_GET['content'] !== title){
	      $disabled = True;
	    }
	    else{
	      $disabled = False;
	    }

	  ?>

          <div id="title">
	    <?php
	      if(!$disabled){
                echo '<div class="col-md-12" style="border: 1px solid black">';
		  while($row = mysqli_fetch_assoc($result_rating)){
	            echo '<div class="row">';
		      echo '<div class="col-md-4">';
		        echo '<p class="text-left" style="font-size:150%">';
		        echo  $row['Name'];
		      echo '</p>';
		      echo '</div>';
		      echo '<div class="col-md-4">';
		        echo '<p class="text-center" style="font-size:150%">';
		        echo  $row['Rating'];
		        echo '</p>';
		      echo '</div>';
		      echo '<div class="col-md-4">';
		        echo '<p class="text-right" style="font-size:150%">';
		        echo  '$' . $row['Price'];
		        echo '</p>';
		      echo '</div>';
	            echo '</div>';
		  }
		  echo '<nav aria-label="Page navigation example">';
		    echo '<ul class="pagination justify-content-center">';
		      if($_GET['page'] <= 1){
		        $disabled = " disabled";
		      }
		    
		      $page_pre = $page - 1;
		      $page_post = $page + 1;

		      echo '<li class="page-item' . $disabled . '">';
		        echo '<a class="page-link" href="/~' . $dbusername . '/store.php?page=' . $page_pre . '&content=title">Previous</a>';
		      echo '</li>';
		      for($page = 1; $page <= $number_of_pages; $page++){
		        if($page == $_GET['page']){
			  $disabled = " disabled";
		        }
		        else{
			  $disabled = "";
		        }

		        echo '<li class="page-item' . $disabled . '">';
		          echo '<a class="page-link" href="/~' . $dbusername . '/store.php?page=' .$page . '&content=title">' . $page . '</a>';
		        echo '</li>';
		      }

		      if($_GET['page'] >= $number_of_pages){
		        $disabled = " disabled";
		      }
		      else{
		        $disabled = "";
		      }

		      echo '<li class="page-item' . $disabled . '">';
                        echo '<a class="page-link" href="/~' . $dbusername . '/store.php?page=' . $page_post . '&content=title">Next</a>';
		      echo '</li>';
		    echo '</ul>';
		  echo '</nav>';
		echo '</dib>';
	      }
	    ?>
          </div>
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