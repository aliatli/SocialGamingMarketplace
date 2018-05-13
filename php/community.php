<?php
session_start();
include_once 'config.php';
if(isset($_SESSION['UserID'])){
  $user_id = $_SESSION['UserID'];
  $_SESSION['UserID'] = $user_id;

  if($_GET['content'] === own_groups){
    $sql_page = "SELECT Grp.Name FROM Grp, Member WHERE Grp.GroupID = Member.GroupGroupID AND Member.UserUserID = '$user_id' ORDER BY Grp.CreationDate ASC;";
  }
  else if($_GET['content'] === all_groups){
    $sql_page = "SELECT Name FROM Grp ORDER BY CreationDate ASC;";
  }
  $result_page = mysqli_query($conn, $sql_page);
  $result_page_check = mysqli_num_rows($result_page);
  if($result_page_check === 0){
    header("Location: ../~$dbusername/logout.php");
    exit();
  }
  $result_per_page = 5;
  $number_of_pages = ceil($result_page_check / $result_per_page);

  if(!isset($_GET['page'])){
    header("Location: ../~$dbusername/community.php?page=1&content=all_groups");
    exit();
  }
  else{
	if(!isset($_GET['page'])){
    	header("Location: ../~$dbusername/community.php?page=1&content=all_groups");
    	exit();
  	}
  }
  $page = $_GET['page'];

  if($page > $number_of_pages || $page < 1){
        header("Location: ../~$dbusername/community.php?page=1");
    exit();
  }
  //Display via pagination
  $starting_limit_index = ($page - 1) * 5;

  if($_GET['content'] === own_groups){
    $sql_rating = "SELECT Name FROM Grp, Member WHERE Grp.GroupID = Member.GroupGroupID AND Member.UserUserID = '$user_id' ORDER BY Grp.CreationDate ASC LIMIT " . $starting_limit_index . ", 5;";
  }
  else if($_GET['content'] === all_groups){
    $sql_rating = "SELECT Name FROM Grp ORDER BY CreationDate ASC LIMIT " . $starting_limit_index . ", 5;";
  }
  $result_page_check = mysqli_num_rows($sql_rating);
  if($result_page_check === 0){
	header("Location: ../~$dbusername/profile.php");
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
    }

    .button-wrapper .btn {
      margin-top: 3%;
    }

    </style>

    <title>Community</title>
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
              <div class="row">
                <div class="col-md-9">
                  <div class="panel panel-default" style="margin-top: 3%">
                    <input class="form-control" placeholder="Search" style="font-size:300%">
                  </div>
                </div>
                <div class="col-md-3" style="margin-top: 5%">
                  <button type="button" class="btn btn-primary">
                    <i class="fa fa-search" style="font-size:300%"></i>
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
          <div class="row">
            <div class="col-md-10">
             <form class="form" role="form" method="post" action="/~<?php echo $dbusername ?>/creategroup.php">
		<div class="col-md-3"></div>
                <label for="create_group" class="col-md-12 col-form-label" style="font-size:200%; text-align: left">Create New Group</label>
                <div class="col-md-3">
                  <label for="create_group" class="col-md-12 col-form-label" style="font-size:100%">Group Name:</label>
                  <div class="col-md-12">
                    <input class="form-control" style="font-size:90%" type="text" value="" id="create_group" name="create_group" maxlength="16" placeholder="Group Name">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-3">
		    <div class="col-md-3"></div>
                    <button type="submit" class="btn btn-primary">Create</button>
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
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
                    <button class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/community.php?page=<?php echo $_GET['page'] ?>&content=all_groups'">
                      <p class="text" style="font-size:100%">All Groups</p>
                    </button>
                  </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
                    <button class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/community.php?page=<?php echo $_GET['page'] ?>&content=own_groups'">
                      <p class="text" style="font-size:100%">Your Groups</p>
                    </button>
                  </div>
                </div>
                <div class="col-md-2"></div>
              </div>
            </div>
            <div class="col-md-3"></div>
          </div>
        </div>
        <div class="col-md-1"></div>
      </div>
    </div>

   <div class="container-fluid">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
	  <?php
	    if($_GET['content'] !== all_groups){
	      $disabled = True;
	    }
	    else{
	      $disabled = False;
	    }
	  ?>
          <div id="all_groups">
	    <?php
	      if(!$disabled){
                echo '<div class="col-md-9" style="border: 1px solid black">';
		  while($row = mysqli_fetch_assoc($result_rating)){
	            echo '<div class="row">';
		      echo '<div class="col-md-4">';
		        echo '<p class="text-left" style="font-size:150%">';
		        echo  $row['Name'];
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
		        echo '<a class="page-link" href="/~' . $dbusername . '/community.php?page=' . $page_pre . '&content=all_groups">Previous</a>';
		      echo '</li>';
		      for($page = 1; $page <= $number_of_pages; $page++){
		        if($page == $_GET['page']){
			  $disabled = " disabled";
		        }
		        else{
			  $disabled = "";
		        }

		        echo '<li class="page-item' . $disabled . '">';
		          echo '<a class="page-link" href="/~' . $dbusername . '/community.php?page=' . $page . '&content=all_groups">' . $page . '</a>';
		        echo '</li>';
		      }

		      if($_GET['page'] >= $number_of_pages){
		        $disabled = " disabled";
		      }
		      else{
		        $disabled = "";
		      }

		      echo '<li class="page-item' . $disabled . '">';
                        echo '<a class="page-link" href="/~' . $dbusername . '/community.php?page=' . $page_post . '&content=all_groups">Next</a>';
		      echo '</li>';
		    echo '</ul>';
		  echo '</nav>';
		echo '</dib>';
	      }
	    ?>
          </div>

	  <?php
	    if($_GET['content'] !== own_groups){
	      $disabled = True;
	    }
	    else{
	      $disabled = False;
	    }

	  ?>

          <div id="own_groups">
	    <?php
	      if(!$disabled){
                echo '<div class="col-md-9" style="border: 1px solid black">';
		  while($row = mysqli_fetch_assoc($result_rating)){
	            echo '<div class="row">';
		      echo '<div class="col-md-4">';
		        echo '<p class="text-left" style="font-size:150%">';
		        echo  $row['Name'];
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
		        echo '<a class="page-link" href="/~' . $dbusername . '/community.php?page=' . $page_pre . '&content=own_groups">Previous</a>';
		      echo '</li>';
		      for($page = 1; $page <= $number_of_pages; $page++){
		        if($page == $_GET['page']){
			  $disabled = " disabled";
		        }
		        else{
			  $disabled = "";
		        }

		        echo '<li class="page-item' . $disabled . '">';
		          echo '<a class="page-link" href="/~' . $dbusername . '/community.php?page=' . $page . '&content=own_groups">' . $page . '</a>';
		        echo '</li>';
		      }

		      if($_GET['page'] >= $number_of_pages){
		        $disabled = " disabled";
		      }
		      else{
		        $disabled = "";
		      }

		      echo '<li class="page-item' . $disabled . '">';
                        echo '<a class="page-link" href="/~' . $dbusername . '/community.php?page=' . $page_post . '&content=own_groups">Next</a>';
		      echo '</li>';
		    echo '</ul>';
		  echo '</nav>';
		echo '</dib>';
	      }
	    ?>
          </div>
        </div>
        <div class="col-md-1"></div>
      </div>
    </div>


    <script language="JavaScript" type="text/javascript">
    function all_groups(){
      var all_groups = document.getElementById("all_groups");
      var your_groups = document.getElementById("your_groups");
      all_groups.style.display = "block";
      your_groups.style.display = "none";
    }

    function your_groups(){
      var all_groups = document.getElementById("all_groups");
      var your_groups = document.getElementById("your_groups");
      all_groups.style.display = "none";
      your_groups.style.display = "block";
    }
    </script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>
