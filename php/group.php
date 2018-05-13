<?php
session_start();
include_once 'config.php';

if(isset($_GET['GroupID'])){
  $group_id = $_GET['GroupID'];
  $user_id = $_SESSION['UserID'];
  $sql_rec = "SELECT * FROM Grp WHERE Name = '$group_id';";
  $result_get_rec = mysqli_query($conn, $sql_rec);

  $_SESSION['UserID'] = $user_id;
  $_SESSION['GameID'] = $game_id;
  if($row = mysqli_fetch_assoc($result_get_rec)){
    $rec_id = $row['GroupID'];
    $rec_name = $row['Name'];
    $rec_date = $row['CreationDate'];
  }

  $sql = "SELECT * FROM Comment WHERE GroupGroupID = '$rec_id';";
  $result2 = mysqli_query($conn, $sql);
  $check = mysqli_num_rows($result2);

  $button = 'Join';
  $sql = "SELECT * FROM Member WHERE GroupGroupID = '$rec_id' AND UserUserID = '$user_id'";
  $result = mysqli_query($conn, $sql);
  $rows = mysqli_num_rows($result);
  if($rows != 0)
	$button = 'Quit';
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
        white-space: normal;
        word-wrap: break-word;
        width: 100%;
    }

    .button-wrapper .btn {
      margin-top: 3%;
    }

    </style>

    <title>Group</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <div class="row">
            <div class="col-md-3">
              <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
                <button type="button" class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/store.php?'">
                  <p class="text" style="font-size:300%">Store</p>
                </button>
              </div>
            </div>
            <div class="col-md-3">
              <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
                <button type="button" class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/profile.php?<?php echo $user_id ?>'">
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
        <div class="col-md-9">
          <div class="col-md-12" style="border:1px solid black">
            <p class="text-center" style="font-size:200%">Group Info</p>
	    <p class="text" style="font-size:300%"><?php echo $group_id?></p>
	    <p class="text" style="font-size:300%"> Created: <?php echo $rec_date?></p>
          </div>
        </div>
        <div class="col-md-1">
          <button class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/joingroup.php?GroupID=<?php echo $group_id?>'" >
            <p class="text" style="font-size:150%"><?php echo $button?></p>
          </button>
          <button class="btn btn-primary" style="height: 100%; display: none">
            <p class="text" style="font-size:150%">Leave</p>
          </button>
        </div>
        <div class="col-md-1"></div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <div class="row">
            <div class="col-md-12" style="border:1px solid black">
              <p class="text-center" style="font-size:300%">Last 10 Comments</p>
		<?php
		if($check !== 0){
	   	  while($row = mysqli_fetch_assoc($result2)){
			$content = $row['Content'];
		        echo '<p class="text" style="font-size:150%">';
		          echo  'Comment: ' . $content . ' ';
		        echo '</p>';
		        echo '<p class="text" style="font-size:150%">';
		          echo  'Date = ' .$row['Date']. ' ' ;
		        echo '</p>';
	          }}?>
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
           <form class="form" role="form" method="post" action="/~<?php echo $dbusername ?>/writecomment.php?GroupID=<?php echo $group_id ?>">
            <div class="col-md-12" style="border:1px solid black">
              <div class="form-group required">
                <label for="write_comment" class="col-md-12 col-form-label" style="font-size:150%">Write Comment:</label>
                <div class="col-md-12">
                  <input class="form-control" placeholder="Write comment" rows="3" style="font-size:100%" id="write_comment" name="write_comment">
                </div>
              </div>
              <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-2" style="margin-bottom: 1%;">
                  <button type="submit" class="btn btn-primary">Send</button>
                </div>
                <div class="col-md-5"></div>
              </div>
            </div>
           </form>
          </div>
        </div>
        <div class="col-md-1"></div>
      </div>
    </div>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>
