<?php
session_start();
include_once 'config.php';
if(isset($_SESSION['UserID'])){
  $user_id = $_SESSION['UserID'];

  if(!isset($_GET['profile_no'])){
    header("Location: ../~$dbusername/profile.php?profile_no=$user_id");
    exit();
  }
  else{
    $profile_id = $_GET['profile_no'];
    if(!isset($_GET['page_game'])){
      header("Location: ../~$dbusername/profile.php?profile_no=$profile_id&page_game=1");
      exit();
    }
    else{
      $page_game = $_GET['page_game'];
      if(!isset($_GET['page_review'])){
        header("Location: ../~$dbusername/profile.php?profile_no=$profile_id&page_game=1&page_review=1");
        exit();
      }
      else{
	$page_review = $_GET['page_review'];
	if(!isset($_GET['page_wish'])){
	  header("Location: ../~$dbusername/profile.php?profile_no=$profile_id&page_game=1&page_review=1&page_wish=1");
	  exit();
	}
	else{
	  $page_wish = $_GET['page_wish'];
	  if(!isset($_GET['page_follow'])){
	    header("Location: ../~$dbusername/profile.php?profile_no=$profile_id&page_game=1&page_review=1&page_wish=1&page_follow=1");
	    exit();
	  }
	  else{
	    $page_follow = $_GET['page_follow'];
	  }
	}
      }
    }
  }

  $sql_profile = "SELECT * FROM User WHERE UserID = '$profile_id';";
  $result_profile = mysqli_query($conn, $sql_profile);
  $result_profile_check = mysqli_num_rows($result_profile);
  
  if($result_profile_check === 0){
    header("Location: ../~$dbusername/profile.php?profile_no=$user_id");
    exit();
  }
  else{
    if($row = mysqli_fetch_assoc($result_profile)){
      $profile_firstname = $row['FirstName'];
      $profile_lastname = $row['LastName'];
      $profile_username = $row['UserName'];
      $profile_email = $row['Email'];
      $profile_dob = $row['DateOfBirth'];
      $profile_balance = $row['Balance'];
    }
  }

  //Block
  $sql_block = "SELECT * FROM BlockList WHERE UserUserID2 = $user_id AND UserUserID = $profile_id;";
  $result_block = mysqli_query($conn, $sql_block);
  $result_block_check = mysqli_num_rows($result_block);

  if($result_block_check !== 0){
    header("Location: ../~$dbusername/profile.php?profile_no=$user_id&page_game=1&page_review=1&page_wish=1&page_follow=1");
    exit();
  }

  //Game
  $result_per_page_game = 3;

  $sql_game = "SELECT Name FROM Game WHERE GameID IN (SELECT GameGameID FROM Buy WHERE UserUserID = $profile_id) ORDER BY Name ASC;";
  $result_game = mysqli_query($conn, $sql_game);
  $result_game_check = mysqli_num_rows($result_game);
  $number_of_pages_game = ceil($result_game_check / $result_per_page_game);

  $page_game = $_GET['page_game'];
  if($page_game > $number_of_pages_game + 1 || $page_game < 1){
    header("Location: ../~$dbusername/profile.php?profile_no=$profile_id&page_game=1&page_review=1&page_wish=1&page_follow=1");
    exit();
  }

  //Display via pagination
  $starting_limit_index_game = ($page_game - 1) * $result_per_page_game;

  $sql_limit_game = "SELECT Name FROM Game WHERE GameID IN (SELECT GameGameID FROM Buy WHERE UserUserID = $profile_id) ORDER BY Name ASC LIMIT $starting_limit_index_game, $result_per_page_game;";

  $result_limit_game = mysqli_query($conn, $sql_limit_game);

  //Review
  $result_per_page_review = 1;

  $sql_review = "SELECT Comment, Rating FROM Write_Review WHERE UserUserID = $profile_id ORDER BY GameGameID;";
  $result_review = mysqli_query($conn, $sql_review);
  $result_review_check = mysqli_num_rows($result_review);
  $number_of_pages_review = ceil($result_review_check / $result_per_page_review);

  $page_review = $_GET['page_review'];
  if($page_review > $number_of_pages_review + 1 || $page_review < 1){
    header("Location: ../~$dbusername/profile.php?profile_no=$profile_id&page_game=1&page_review=1&page_wish=1&page_follow=1");
    exit();
  }

  //Display via pagination
  $starting_limit_index_review = ($page_review - 1) * $result_per_page_review;

  $sql_limit_review = "SELECT Comment, Rating FROM Write_Review WHERE UserUserID = $profile_id ORDER BY GameGameID LIMIT $starting_limit_index_review, $result_per_page_review;";

  $result_limit_review = mysqli_query($conn, $sql_limit_review);

  //Wish
  $result_per_page_wish = 3;

  $sql_wish = "SELECT Name FROM Game WHERE GameID IN (SELECT GameGameID FROM WishList WHERE UserUserID = $profile_id) ORDER BY Name ASC;";
  $result_wish = mysqli_query($conn, $sql_wish);
  $result_wish_check = mysqli_num_rows($result_wish);
  $number_of_pages_wish = ceil($result_wish_check / $result_per_page_wish);

  $page_wish = $_GET['page_wish'];

  if($page_wish > $number_of_pages_wish + 1 || $page_wish < 1){
    header("Location: ../~$dbusername/profile.php?profile_no=$profile_id&page_game=1&page_review=1&page_wish=1&page_follow=1");
    exit();
  }

  //Display via pagination
  $starting_limit_index_wish = ($page_wish - 1) * $result_per_page_wish;

  $sql_limit_wish = "SELECT Name FROM Game WHERE GameID IN (SELECT GameGameID FROM WishList WHERE UserUserID = $profile_id) ORDER BY Name ASC LIMIT $starting_limit_index_wish, $result_per_page_wish;";

  $result_limit_wish = mysqli_query($conn, $sql_limit_wish);

  //Follow
  $result_per_page_follow = 3;

  $sql_follow = "SELECT UserName FROM User WHERE UserID IN (SELECT UserUserID2 FROM FriendList WHERE UserUserID = $profile_id UNION DISTINCT SELECT UserUserID FROM FriendList WHERE UserUserID2 = $profile_id) ORDER BY UserName ASC;";
  $result_follow = mysqli_query($conn, $sql_follow);
  $result_follow_check = mysqli_num_rows($result_follow);
  $number_of_pages_follow = ceil($result_follow_check / $result_per_page_follow);

  $page_follow = $_GET['page_follow'];

  if($page_follow > $number_of_pages_follow + 1 || $page_follow < 1){
    header("Location: ../~$dbusername/profile.php?profile_no=$profile_id&page_game=1&page_review=1&page_wish=1&page_follow=1");
    exit();
  }

  //Display via pagination
  $starting_limit_index_follow = ($page_follow - 1) * $result_per_page_follow;

  $sql_limit_follow = "SELECT UserName FROM User WHERE UserID IN (SELECT UserUserID2 FROM FriendList WHERE UserUserID = $profile_id UNION DISTINCT SELECT UserUserID FROM FriendList WHERE UserUserID2 = $profile_id) ORDER BY UserName ASC LIMIT $starting_limit_index_follow, $result_per_page_follow;";

  $result_limit_follow = mysqli_query($conn, $sql_limit_follow);

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

    <title>Profile</title>
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
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-4" style="border: 1px solid black">
              <img src="images/<?php echo $user_id ?>.jpg" class="img-responsive" alt="Image" style="border: 1px solid black; width: 100%; height: 45%">
            </div>
	    <!--
	      $profile_firstname = $row['FirstName'];
	      $profile_lastname = $row['LastName'];
	      $profile_username = $row['UserName'];
	      $profile_email = $row['Email'];
	      $profile_dob = $row['DateOfBirth'];
	      $profile_balance = $row['Balance'];
	    -->
            <div class="col-md-8" style="border:1px solid black">
              <p class="text-left" style="font-size:400%">
		Username: <?php echo $profile_username ?>
	      </p>
              <p class="text-left" style="font-size:200%">
		First Name: <?php echo $profile_firstname ?>
	      </p>
              <p class="text-left" style="font-size:200%">
		Last Name: <?php echo $profile_lastname ?>
	      </p>
              <p class="text-left" style="font-size:250%">
		E-mail: <?php echo $profile_email ?>	      
	      </p>
              <p class="text-left" style="font-size:150%">
		Date of Birth (YYYY-MM-DD): <?php echo $profile_dob ?>	      
	      </p>
              <p class="text-left" style="font-size:150%">
		Balance: $<?php echo $profile_balance ?>	      
	      </p>
            </div>
          </div>
        </div>
        <div class="col-md-1">
	  <?php
	    if($user_id === $profile_id){
              echo '<button class="btn btn-primary" style="margin-top: 6%; height: 14%"' . 'onclick="location.href=\'/~' . $dbusername . '/manage_info.php\'"' . '>';
                echo '<p class="text" style="font-size:150%">Manage Info</p>';
              echo '</button>';
              echo '<button class="btn btn-primary" style="margin-top: 6%; height: 14%"' . 'onclick="location.href=\'/~' . $dbusername . '/inventory.php\'"' . '>';
                echo '<p class="text" style="font-size:150%">Inventory</p>';
              echo '</button>';
              echo '<button class="btn btn-primary" style="margin-top: 6%; height: 14%"' . 'onclick="location.href=\'/~' . $dbusername . '/logout.php\'"' . '>';
                echo '<p class="text" style="font-size:150%">Logout</p>';
              echo '</button>';
	    }
	    else{
/*
  FOLLOW/UNFOLLOW
  BLOCK/UNBLOCK
  MESSAGE
*/


	      $sql_follow = "SELECT * FROM FriendList WHERE UserUserID = $user_id AND UserUserID2 = $profile_id;";
	      $result_follow = mysqli_query($conn, $sql_follow);
	      $result_follow_check = mysqli_num_rows($result_follow);

	      $sql_block = "SELECT * FROM BlockList WHERE UserUserID = $user_id AND UserUserID2 = $profile_id;";
	      $result_block = mysqli_query($conn, $sql_block);
	      $result_block_check = mysqli_num_rows($result_block);

	      if($result_follow_check === 0){
                echo '<button class="btn btn-primary" style="margin-top: 6%; height: 14%"' . 'onclick="location.href=\'/~' . $dbusername . '/follow.php?profile_id=' . $profile_id .'\'"' . '>';
                  echo '<p class="text" style="font-size:150%">Follow</p>';
                echo '</button>';
	      }
	      else{
                echo '<button class="btn btn-primary" style="margin-top: 6%; height: 14%"' . 'onclick="location.href=\'/~' . $dbusername . '/follow.php?profile_id=' . $profile_id .'\'"' . '>';
                  echo '<p class="text" style="font-size:150%">Unfollow</p>';
                echo '</button>';
	      }

	      if($result_block_check === 0){
                echo '<button class="btn btn-primary" style="margin-top: 6%; height: 14%"' . 'onclick="location.href=\'/~' . $dbusername . '/block.php?profile_id=' . $profile_id .'\'"' . '>';
                  echo '<p class="text" style="font-size:150%">Block</p>';
                echo '</button>';
	      }
	      else{
                echo '<button class="btn btn-primary" style="margin-top: 6%; height: 14%"' . 'onclick="location.href=\'/~' . $dbusername . '/block.php?profile_id=' . $profile_id .'\'"' . '>';
                  echo '<p class="text" style="font-size:150%">Unblock</p>';
                echo '</button>';
	      }

              echo '<button class="btn btn-primary" style="margin-top: 6%; height: 14%"' . 'onclick="location.href=\'/~' . $dbusername . '/message.php?profile_id=' . $profile_id .'\'"' . '>';
                echo '<p class="text" style="font-size:150%">Message</p>';
              echo '</button>';
	    }
	  ?>
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
                <p class="text-center" style="font-size:200%">Games</p>
                <?php
		  while($row = mysqli_fetch_assoc($result_limit_game)){
		    echo '<p class="text-center" style="font-size:150%">';
		      echo  $row['Name'];
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
		        echo '<a class="page-link" href="/~' . $dbusername . '/profile.php?profile_no=' . $profile_id . '&page_game=' . $page_pre . '&page_review=' . $page_review . '&page_wish=' . $page_wish . '&page_follow=' . $page_follow . '">Previous</a>';
		      echo '</li>';
		      for($page = 1; $page <= $number_of_pages_game; $page++){
		        if($page == $_GET['page_game']){
		  	  $disabled = " disabled";
		        }
		        else{
			  $disabled = "";
		        }

		        echo '<li class="page-item' . $disabled . '">';
		          echo '<a class="page-link" href="/~' . $dbusername . '/profile.php?profile_no=' . $profile_id . '&page_game=' . $page . '&page_review=' . $page_review . '&page_wish=' . $page_wish . '&page_follow=' . $page_follow . '">' . $page . '</a>';
		        echo '</li>';
		      }

		      if($_GET['page_game'] >= $number_of_pages_game){
		        $disabled = " disabled";
		      }
		      else{
		        $disabled = "";
		      }

		      echo '<li class="page-item' . $disabled . '">';
                        echo '<a class="page-link" href="/~' . $dbusername . '/profile.php?profile_no=' . $profile_id . '&page_game=' . $page_post . '&page_review=' . $page_review . '&page_wish=' . $page_wish . '&page_follow=' . $page_follow . '">Next</a>';
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
                <p class="text-center" style="font-size:200%">Reviews</p>
		<p class="text-left" style="font-size:150%">Comment:</p>
                <?php
		  while($row = mysqli_fetch_assoc($result_limit_review)){
		    echo '<p class="text-left" style="font-size:100%">';
		      echo  $row['Comment'];
		    echo '</p>';
		  }
		  echo '<nav aria-label="Page navigation example">';
		    echo '<ul class="pagination justify-content-center">';
		      if($_GET['page_review'] <= 1){
			$disabled = " disabled";
		      }
		      else{
			$disabled = "";
		      }

		      $page_pre = $page_review - 1;
		      $page_post = $page_review + 1;
		      echo '<li class="page-item' . $disabled . '">';
			echo '<a class="page-link" href="/~' . $dbusername . '/profile.php?profile_no=' . $profile_id . '&page_game=' . $page_game . '&page_review=' . $page_pre . '&page_wish=' . $page_wish . '&page_follow=' . $page_follow . '">Previous</a>';
		      echo '</li>';
		      for($page = 1; $page <= $number_of_pages_review; $page++){
			if($page == $_GET['page_review']){
			  $disabled = " disabled";
			}
			else{
			  $disabled = "";
			}

			echo '<li class="page-item' . $disabled . '">';
			echo '<a class="page-link" href="/~' . $dbusername . '/profile.php?profile_no=' . $profile_id . '&page_game=' . $page_game . '&page_review=' . $page . '&page_wish=' . $page_wish . '&page_follow=' . $page_follow . '">' . $page . '</a>';
			echo '</li>';
		      }

		      if($_GET['page_review'] >= $number_of_pages_review){
			$disabled = " disabled";
		      }
		      else{
			$disabled = "";
		      }

		      echo '<li class="page-item' . $disabled . '">';
			echo '<a class="page-link" href="/~' . $dbusername . '/profile.php?profile_no=' . $profile_id . '&page_game=' . $page_game . '&page_review=' . $page_post . '&page_wish=' . $page_wish . '&page_follow=' . $page_follow . '">Next</a>';
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
                <p class="text-center" style="font-size:200%">Wish List</p>
		<?php
		  while($row = mysqli_fetch_assoc($result_limit_wish)){
		    echo '<p class="text-center" style="font-size:150%">';
		      echo  $row['Name'];
		    echo '</p>';
		  }
		  echo '<nav aria-label="Page navigation example">';
		    echo '<ul class="pagination justify-content-center">';
		      if($_GET['page_wish'] <= 1){
			$disabled = " disabled";
		      }
		      else{
			$disabled = "";
		      }

		      $page_pre = $page_wish - 1;
		      $page_post = $page_wish + 1;
		      echo '<li class="page-item' . $disabled . '">';
			echo '<a class="page-link" href="/~' . $dbusername . '/profile.php?profile_no=' . $profile_id . '&page_game=' . $page_game . '&page_review=' . $page_review . '&page_wish=' . $page_pre . '&page_follow=' . $page_follow . '">Previous</a>';
		      echo '</li>';
		      for($page = 1; $page <= $number_of_pages_wish; $page++){
			if($page == $_GET['page_wish']){
			  $disabled = " disabled";
			}
			else{
			  $disabled = "";
			}

			echo '<li class="page-item' . $disabled . '">';
			  echo '<a class="page-link" href="/~' . $dbusername . '/profile.php?profile_no=' . $profile_id . '&page_game=' . $page_game . '&page_review=' . $page_review . '&page_wish=' . $page . '&page_follow=' . $page_follow . '">' . $page . '</a>';
			echo '</li>';
		      }

		      if($_GET['page_wish'] >= $number_of_pages_wish){
			$disabled = " disabled";
		      }
		      else{
			$disabled = "";
		      }

		      echo '<li class="page-item' . $disabled . '">';
		        echo '<a class="page-link" href="/~' . $dbusername . '/profile.php?profile_no=' . $profile_id . '&page_game=' . $page_game . '&page_review=' . $page_review . '&page_wish=' . $page_post . '&page_follow=' . $page_follow . '">Next</a>';
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
                <p class="text-center" style="font-size:200%">Follower List</p>
		<?php
		  while($row = mysqli_fetch_assoc($result_limit_follow)){
		    echo '<p class="text-center" style="font-size:150%">';
		      echo  $row['UserName'];
		    echo '</p>';
		  }
		  echo '<nav aria-label="Page navigation example">';
		    echo '<ul class="pagination justify-content-center">';
		      if($_GET['page_follow'] <= 1){
			$disabled = " disabled";
		      }
		      else{
			$disabled = "";
		      }

		      $page_pre = $page_follow - 1;
		      $page_post = $page_follow + 1;
		      echo '<li class="page-item' . $disabled . '">';
			echo '<a class="page-link" href="/~' . $dbusername . '/profile.php?profile_no=' . $profile_id . '&page_game=' . $page_game . '&page_review=' . $page_review . '&page_wish=' . $page_wish . '&page_follow=' . $page_pre . '">Previous</a>';
		      echo '</li>';
		      for($page = 1; $page <= $number_of_pages_follow; $page++){
			if($page == $_GET['page_follow']){
			  $disabled = " disabled";
			}
			else{
			  $disabled = "";
			}

			echo '<li class="page-item' . $disabled . '">';
			  echo '<a class="page-link" href="/~' . $dbusername . '/profile.php?profile_no=' . $profile_id . '&page_game=' . $page_game . '&page_review=' . $page_review . '&page_wish=' . $page_wish . '&page_follow=' . $page . '">' . $page . '</a>';
			echo '</li>';
		      }

		      if($_GET['page_follow'] >= $number_of_pages_follow){
			$disabled = " disabled";
		      }
		      else{
			$disabled = "";
		      }

		      echo '<li class="page-item' . $disabled . '">';
			echo '<a class="page-link" href="/~' . $dbusername . '/profile.php?profile_no=' . $profile_id . '&page_game=' . $page_game . '&page_review=' . $page_review . '&page_wish=' . $page_wish . '&page_follow=' . $page_post . '">Next</a>';
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
