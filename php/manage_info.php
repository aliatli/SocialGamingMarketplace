<?php
session_start();
include_once 'config.php';
if(isset($_SESSION['UserID'])){
  $user_id = $_SESSION['UserID'];

  if(!isset($_GET['content'])){
    header("Location: ../~$dbusername/manage_info.php?content=manage_payment");
  }
  else{
    $content = $_GET['content'];
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
    }
    .button-wrapper .btn {
      margin-top: 3%;
    }
    .img-responsive{
      max-width: 100%;
      max-height: 100%;
    }
    .form-control{
      padding-left:0;
      padding-top:0;
      padding-bottom:0.4em;
      padding-right: 0.4em;
    }
    </style>

    <title>Manage Information</title>
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

    <p class="text-center" style="font-size:300%; margin-top: 2%">Manage Information</p>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-3">
                <div class="panel panel-default" style="display: flex;justify-content: center;align-items: center">
                  <button class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/manage_info.php?content=manage_payment'">
                    <p class="text" style="font-size:100%">Manage Payment Information</p>
                  </button>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-default" style="display: flex-end;justify-content: center;align-items: center">
                  <button class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/manage_info.php?content=manage_password'">
                    <p class="text" style="font-size:100%">Manage Password</p>
                  </button>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-default" style="display: flex-end;justify-content: center;align-items: center">
                  <button class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/manage_info.php?content=change_picture'">
                    <p class="text" style="font-size:100%">Change Profile Picture</p>
                  </button>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-default" style="display: flex-start;justify-content: center;align-items: center;">
                  <button class="btn btn-primary" onclick="location.href='/~<?php echo $dbusername ?>/manage_info.php?content=add_balance'">
                    <p class="text" style="font-size:100%">Add Balance</p>
                  </button>
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
            <div class="col-md-3"></div>
            <div class="col-md-6">
	      <?php
	      $sql_old_info = "SELECT BillingAddress, CardNo, Cvv FROM User WHERE UserID = $user_id;";
	      $result_old_info = mysqli_query($conn, $sql_old_info);
	      if($row = mysqli_fetch_assoc($result_old_info)){
	        $old_address = $row['BillingAddress'];
		$old_cardno = $row['CardNo'];
		$old_cvv = $row['Cvv'];
	      }

	      if($_GET['content'] === manage_payment){
		echo '<form class="form" method="post" action="/~' . $dbusername . '/manage_payment.php">';
                echo '<div id="manage_payment">';
                  echo '<div class="norow">';
                    echo '<div class="col-md-12" style="border: 1px solid black">';
                      echo '<div class="form-group required">';
                        echo '<label for="billing_address" class="col-md-12 col-form-label" style="font-size:120%">Billing Address:</label>';
                        echo '<div class="col-md-12">';
                          echo '<textarea class="form-control" style="font-size: 90%; min-height: 100px; max-height: 100px" rows="3" id="billing_address" maxlength="256" placeholder="" name="address">' . $old_address . '</textarea>';
                        echo '</div>';
                      echo '</div>';
                      echo '<label for="card_no" class="col-md-12 col-form-label" style="font-size:120%">Payment Details:</label>';
                      echo '<div class="form-group required">';
                        echo '<label for="card_no" class="col-md-12 col-form-label" style="font-size:100%">Card No:</label>';
                        echo '<div class="col-md-12">';
                          echo '<input class="form-control" style="font-size:90%" type="text" value="' . $old_cardno . '" id="card_no" maxlength="19" placeholder="**** **** **** ****" onkeyup="card_no_spacing()" name="card_no">';
                        echo '</div>';
                      echo '</div>';
                      echo '<div class="form-group required">';
                        echo '<label for="cvv" class="col-md-12 col-form-label" style="font-size:100%">CVV:</label>';
                        echo '<div class="col-md-12">';
                          echo '<input class="form-control" style="font-size:90%" type="text" value="' . $old_cvv . '" id="cvv" maxlength="3" placeholder="123" onkeyup="cvv()" name="cvv">';
                        echo '</div>';
                      echo '</div>';
                      echo '<div class="form-group">';
                        echo '<div class="col-md-6">';
                          echo '<button type="submit" class="btn btn-primary" name="manage_payment">Save Payment Method</button>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                echo '</div>';
		echo '</form>';
	      }

	      if($_GET['content'] === manage_password){
		echo '<form class="form" method="post" action="/~' . $dbusername . '/manage_password.php">';
                echo '<div id="manage_password">';
                  echo '<div class="norow">';
                    echo '<div class="col-md-12" style="border: 1px solid black">';
                      echo '<label for="old_password" class="col-md-12 col-form-label" style="font-size:120%">Change Your Password:</label>';
                      echo '<div class="form-group required">';
                        echo '<label for="old_password" class="col-md-12 col-form-label" style="font-size:100%">Old Password:</label>';
                        echo '<div class="col-md-12">';
                          echo '<input class="form-control" style="font-size:90%" type="password" value="" id="old_password" maxlength="16" placeholder="Old Password" name="old_password">';
                        echo '</div>';
                      echo '</div>';
                      echo '<div class="form-group required">';
                        echo '<label for="new_password" class="col-md-12 col-form-label" style="font-size:100%">New Password:</label>';
                        echo '<div class="col-md-12">';
                          echo '<input class="form-control" style="font-size:90%" type="password" value="" id="new_password" maxlength="16" placeholder="New Password" name="new_password">';
                        echo '</div>';
                      echo '</div>';
                      echo '<div class="form-group required">';
                        echo '<label for="confirm_password" class="col-md-12 col-form-label" style="font-size:100%">Confirm New Password:</label>';
                        echo '<div class="col-md-12">';
                          echo '<input class="form-control" style="font-size:90%" type="password" value="" id="confirm_password" maxlength="16" placeholder="Confirm New Password" name="password_confirm">';
                        echo '</div>';
                      echo '</div>';
                      echo '<div class="form-group">';
                        echo '<div class="col-md-6">';
                          echo '<button type="submit" class="btn btn-primary" name="manage_password">Save New Password</button>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                echo '</div>';
		echo '</form>';
              } 

	      if($_GET['content'] === change_picture){
                echo '<div id="change_image">';

                echo '</div>';
              }

	      if($_GET['content'] === add_balance){
		echo '<form class="form" method="post" action="/~' . $dbusername . '/add_balance.php">';
                echo '<div id="add_balance">';
                  echo '<div class="norow">';
                    echo '<div class="col-md-12" style="border: 1px solid black">';
                      echo '<label for="balance" class="col-md-12 col-form-label" style="font-size:120%">Add Balance:</label>';
                      echo '<div class="form-group required">';
                        echo '<div class="col-md-12">';
                          echo '<input class="form-control" style="font-size:90%" type="text" value="" id="balance" maxlength="16" placeholder="Add Balance" onkeyup="display_add_balance()" name="new_balance">';
                        echo '</div>';
                        echo '<div class="col-md-12" style="margin-top: 2%">';
                          echo '<p class="text" style="font-size:120%" id="display_add_balance"></p>';
                        echo '</div>';
                      echo '</div>';
                      echo '<div class="form-group">';
                        echo '<div class="col-md-6">';
                          echo '<button type="submit" class="btn btn-primary" onmouseup="add_balance()" name="add_balance">Add balance</button>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                echo '</div>';
		echo '</form>';
              }
	    ?>
            </div>
            <div class="col-md-3"></div>
          </div>
        </div>
        <div class="col-md-2"></div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <script language="JavaScript" type="text/javascript">
    function card_no_spacing(){
      var card_no_value = document.getElementById("card_no").value;
      var new_card_no_value = card_no_value.replace(/\s+/g, '').replace(/[^0-9\ ]+/g, '');
      if(new_card_no_value.length > 16){
        new_card_no_value = new_card_no_value.substring(0, 16);
      }
      if(new_card_no_value.length > 4){
        new_card_no_value = new_card_no_value.substring(0, 4) + "-" + new_card_no_value.substring(4, new_card_no_value.length);
      }
      if(new_card_no_value.length > 9){
        new_card_no_value = new_card_no_value.substring(0, 9) + "-" + new_card_no_value.substring(9, new_card_no_value.length);
      }
      if(new_card_no_value.length > 14){
        new_card_no_value = new_card_no_value.substring(0, 14) + "-" + new_card_no_value.substring(14, new_card_no_value.length);
      }
      document.getElementById("card_no").value = new_card_no_value;
    }
    function expiry_date(){
      var expiry_date_value = document.getElementById("expiry_date").value;
      var new_expiry_date_value = expiry_date_value.replace(/\s+/g, '').replace(/[^0-9\ ]+/g, '');
      if(new_expiry_date_value.length === 5){
        new_expiry_date_value = new_expiry_date_value.substring(1, 5);
      }
      if(new_expiry_date_value.substring(0, 2) > 12){
        new_expiry_date_value = "12" + new_expiry_date_value.substring(2, new_expiry_date_value.length)
      }
      /*
        Add expections for every month!
      */
      if(new_expiry_date_value.substring(2, 4) > 31){
        new_expiry_date_value = new_expiry_date_value.substring(0, 2) + "31";
      }
      if(new_expiry_date_value.length > 2){
        new_expiry_date_value = new_expiry_date_value.substring(0, 2) + "/" + new_expiry_date_value.substring(2, new_expiry_date_value.length)
      }
      document.getElementById("expiry_date").value = new_expiry_date_value;
    }
    function cvv(){
      var cvv_value = document.getElementById("cvv").value;
      var new_cvv_value = cvv_value.replace(/\s+/g, '').replace(/[^0-9\ ]+/g, '');
      document.getElementById("cvv").value = new_cvv_value;
    }
    function display_add_balance(){
      var balance = document.getElementById("balance").value;
      document.getElementById("display_add_balance").innerHTML= "$" + balance;
    }
    </script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>