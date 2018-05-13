<?php
session_start();
include_once 'config.php';
if(isset($_SESSION['UserID'])){
  if(isset($_GET['search_content'])){
    $search_content = $_GET['search_content'];
  }
  else{
    $search_content = mysqli_real_escape_string($conn, $_POST['search_content']);
  }

  if(!isset($search_content)){
    header("Location: ../~$dbusername/profile.php");
    exit();
  }
  else if(!isset($_GET['search_content'])){
    header("Location: ../~$dbusername/search.php?search_content=$search_content");
    exit();
  }

  if(!isset($_GET['page_user'])){
    header("Location: ../~$dbusername/search.php?search_content=$search_content&page_user=1");
    exit();
  }
  else{
    $page_user = $_GET['page_user'];
    if(!isset($_GET['page_game'])){
      header("Location: ../~$dbusername/search.php?search_content=$search_content&page_user=$page_user&page_game=1");
      exit();
    }
    else{
      $page_game = $_GET['page_game'];
      if(!isset($_GET['page_group'])){
        header("Location: ../~$dbusername/search.php?search_content=$search_content&page_user=$page_user&page_game=$page_game&page_group=1");
        exit();
      }
      else{
        $page_game = $_GET['page_game'];
      }
    }
  }
  
  //User
  $result_per_page_user = 5;

  $sql_user = "SELECT * FROM User WHERE UserName LIKE '%$search_content%' OR FirstName LIKE '%$search_content%' OR LastName LIKE '%$search_content%' OR Email LIKE '%$search_content%' ORDER BY UserID ASC;";
  $result_user = mysqli_query($conn, $sql_user);
  $result_user_check = mysqli_num_rows($result_user);
  $number_of_pages_user = ceil($result_user_check / $result_per_page_user);

  $page_user = $_GET['page_user'];
  if($page_user > $number_of_pages_user + 1 || $page_user < 1){
    header("Location: ../~$dbusername/search.php?search_content=$search_content&page_user=1&page_game=1&page_group=1");
    exit();
  }

  //Display via pagination
  $starting_limit_index_user = ($page_user - 1) * $result_per_page_user;

  $sql_limit_user = "SELECT * FROM User WHERE UserName LIKE '%$search_content%' OR FirstName LIKE '%$search_content%' OR LastName LIKE '%$search_content%' OR Email LIKE '%$search_content%' ORDER BY UserID ASC LIMIT $starting_limit_index_user, $result_per_page_user;";

  $result_limit_user = mysqli_query($conn, $sql_limit_user);

  //Game
  $result_per_page_game = 5;

  $sql_game = "SELECT * FROM Game WHERE Name LIKE '%$search_content%' ORDER BY Name ASC;";
  $result_game = mysqli_query($conn, $sql_game);
  $result_game_check = mysqli_num_rows($result_game);
  $number_of_pages_game = ceil($result_game_check / $result_per_page_game);

  $page_game = $_GET['page_game'];
  if($page_game > $number_of_pages_game + 1 || $page_game < 1){
    header("Location: ../~$dbusername/search.php?search_content=$search_content&page_user=1&page_game=1&page_group=1");
    exit();
  }

  //Display via pagination
  $starting_limit_index_game = ($page_game - 1) * $result_per_page_game;

  $sql_limit_game = "SELECT * FROM Game WHERE Name LIKE '%$search_content%' ORDER BY Name ASC LIMIT $starting_limit_index_game, $result_per_page_game;";

  $result_limit_game = mysqli_query($conn, $sql_limit_game);
  
  //Group
  $result_per_page_group = 5;

  $sql_group = "SELECT * FROM Grp WHERE Name LIKE '%$search_content%' ORDER BY Name ASC;";
  $result_group = mysqli_query($conn, $sql_group);
  $result_group_check = mysqli_num_rows($result_group);
  $number_of_pages_group = ceil($result_group_check / $result_per_page_group);

  $page_group = $_GET['page_group'];
  if($page_group > $number_of_pages_group + 1 || $page_group < 1){
    header("Location: ../~$dbusername/search.php?search_content=$search_content&page_user=1&page_game=1&page_group=1");
    exit();
  }

  //Display via pagination
  $starting_limit_index_group = ($page_group - 1) * $result_per_page_group;

  $sql_limit_group = "SELECT * FROM Grp WHERE Name LIKE '%$search_content%' ORDER BY Name ASC LIMIT $starting_limit_index_group, $result_per_page_group;";

  $result_limit_group = mysqli_query($conn, $sql_limit_group);

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
    }
    .button-wrapper .btn {
      margin-top: 3%;
    }
    .img-responsive{
      max-width: 100%;
      max-height: 100%;
    }
    </style>

    <title>Search</title>
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
                <button type="button" class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/profile.php?profile_no=<?php echo $user_id ?>'">
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
          <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
            <div class="col-md-12" style="border: 1px solid black">
              <div class="norow">
                <p class="text-center" style="font-size:200%">Games</p>
                <?php
		  while($row = mysqli_fetch_assoc($result_limit_game)){
		    echo '<p class="text-center" style="font-size:150%">';
		      $link_var = $row['GameID'];
		      echo '<a href="/~' . $dbusername . '/game.php?GameID=' . $link_var . '">';
		        echo  $row['Name'];
		      echo '</a>';
		    echo '</p>';
		  }
		  echo '<nav aria-label="Page navigation example">';
		    echo '<ul class="pagination justify-content-center">';
		      if($_GET['page_game'] <= 1){
		        $disabled = " disabled";
		      }
		      else{
			$disabled = "";
		      }
		    
		      $page_pre = $page_game - 1;
		      $page_post = $page_game + 1;
		      echo '<li class="page-item' . $disabled . '">';
		        echo '<a class="page-link" href="/~' . $dbusername . '/search.php?search_content=' . $search_content . '&page_user=' . $page_user . '&page_game=' . $page_pre . '&page_group=' . $page_group . '">Previous</a>';
		      echo '</li>';
		      for($page = 1; $page <= $number_of_pages_game; $page++){
		        if($page == $_GET['page_game']){
		  	  $disabled = " disabled";
		        }
		        else{
			  $disabled = "";
		        }

		        echo '<li class="page-item' . $disabled . '">';
		          echo '<a class="page-link" href="/~' . $dbusername . '/search.php?search_content=' . $search_content . '&page_user=' . $page_user . '&page_game=' . $page . '&page_group=' . $page_group . '">'. $page . '</a>';
		        echo '</li>';
		      }

		      if($_GET['page_game'] >= $number_of_pages_game){
		        $disabled = " disabled";
		      }
		      else{
		        $disabled = "";
		      }

		      echo '<li class="page-item' . $disabled . '">';
		        echo '<a class="page-link" href="/~' . $dbusername . '/search.php?search_content=' . $search_content . '&page_user=' . $page_user . '&page_game=' . $page_post . '&page_group=' . $page_group . '">Previous</a>';
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

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-5">
          <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
            <div class="col-md-12" style="border: 1px solid black">
              <div class="norow">
                <p class="text-center" style="font-size:200%">Users</p>
		<?php
		while($row = mysqli_fetch_assoc($result_limit_user)){
		  echo '<p class="text-center" style="font-size:150%">';
		    $link_var = $row['UserID'];
		    echo '<a href="/~' . $dbusername . '/profile.php?profile_no=' . $link_var . '">';
		      echo  $row['UserName'];
		    echo '</a>';
		  echo '</p>';
		}
		
		echo '<nav aria-label="Page navigation example">';
		  echo '<ul class="pagination justify-content-center">';
		    if($_GET['page_user'] <= 1){
		      $disabled = " disabled";
		    }
		    else{
		      $disabled = "";
		    }

		    $page_pre = $page_user - 1;
		    $page_post = $page_user + 1;
		    echo '<li class="page-item' . $disabled . '">';
		      echo '<a class="page-link" href="/~' . $dbusername . '/search.php?search_content=' . $search_content . '&page_user=' . $page_pre . '&page_game=' . $page_game . '&page_group=' . $page_group . '">Previous</a>';
		    echo '</li>';
		    for($page = 1; $page <= $number_of_pages_user; $page++){
		      if($page == $_GET['page_user']){
		        $disabled = " disabled";
		      }
		      else{
		        $disabled = "";
		      }

		      echo '<li class="page-item' . $disabled . '">';
		        echo '<a class="page-link" href="/~' . $dbusername . '/search.php?search_content=' . $search_content . '&page_user=' . $page . '&page_game=' . $page_game . '&page_group=' . $page_group . '">'. $page . '</a>';
		      echo '</li>';
		    }

		    if($_GET['page_user'] >= $number_of_pages_user){
		      $disabled = " disabled";
		    }
		    else{
		      $disabled = "";
		    }

		    echo '<li class="page-item' . $disabled . '">';
		      echo '<a class="page-link" href="/~' . $dbusername . '/search.php?search_content=' . $search_content . '&page_user=' . $page_post . '&page_game=' . $page_game . '&page_group=' . $page_group . '">Previous</a>';
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
                <p class="text-center" style="font-size:200%">Groups</p>
		<?php
		while($row = mysqli_fetch_assoc($result_limit_group)){
		  echo '<p class="text-center" style="font-size:150%">';
		    echo  $row['Name'];
		  echo '</p>';
		}
		
		echo '<nav aria-label="Page navigation example">';
		  echo '<ul class="pagination justify-content-center">';
		    if($_GET['page_group'] <= 1){
		      $disabled = " disabled";
		    }
		    else{
		      $disabled = "";
		    }

		    $page_pre = $page_group - 1;
		    $page_post = $page_group + 1;
		    echo '<li class="page-item' . $disabled . '">';
		      echo '<a class="page-link" href="/~' . $dbusername . '/search.php?search_content=' . $search_content . '&page_user=' . $page_user . '&page_game=' . $page_game . '&page_group=' . $page_pre . '">Previous</a>';
		    echo '</li>';
		    for($page = 1; $page <= $number_of_pages_group; $page++){
		      if($page == $_GET['page_group']){
		        $disabled = " disabled";
		      }
		      else{
		        $disabled = "";
		      }

		      echo '<li class="page-item' . $disabled . '">';
		        echo '<a class="page-link" href="/~' . $dbusername . '/search.php?search_content=' . $search_content . '&page_user=' . $page_user . '&page_game=' . $page_game . '&page_group=' . $page . '">' . $page . '</a>';
		      echo '</li>';
		    }

		    if($_GET['page_group'] >= $number_of_pages_group){
		      $disabled = " disabled";
		    }
		    else{
		      $disabled = "";
		    }

		    echo '<li class="page-item' . $disabled . '">';
		      echo '<a class="page-link" href="/~' . $dbusername . '/search.php?search_content=' . $search_content . '&page_user=' . $page_user . '&page_game=' . $page_game . '&page_group=' . $page_post . '">Previous</a>';
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