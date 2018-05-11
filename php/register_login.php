<?php
session_start();
include("config.php");
?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <style>
    .panel-default {
      border: 1px solid black;
      overflow: auto;
    }
    .container-fluid {
      margin-top: 25px;
    }
    </style>

    <title>Register or Login</title>
  </head>

  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-1"></div>

        <div class="col-sm-10">
          <div class="panel panel-default">
          <p class="text-center" style="font-size:300%">Social Gaming Market Place</p>
          </div>
        </div>

        <div class="col-sm-1"></div>
      </div>
    </div>
    <div class="container-fluid h-100">
      <div class="row h-100 justify-content-center align-items-center">
        <!-- Login -->

        <!-- Variables
        email_or_username
        password_login
        -->
        <div class="col-sm-3" style="min-width: 200px">
          <form class="form" role="form" method="post" action="/~<?php echo $dbusername ?>/login.php">
            <div class="panel panel-default">
              <p class="text-center" style="font-size:150%">Login</p>
              <label for="email_or_username" class="col-sm-12 col-form-label" style="font-size:120%">Username:</label>
              <div class="col-sm-12">
                <input class="form-control" style="font-size:90%" type="text" value="" id="email_or_username" name="email_or_username" onkeyup="email_or_username_func()" maxlength="32" placeholder="E-mail or Username">
              </div>

              <label for="password_login" class="col-sm-12 col-form-label" style="font-size:120%">Password:</label>
              <div class="col-sm-12">
                <input class="form-control" style="font-size:90%" type="password" value="" id="password_login" name="password_login" maxlength="16" placeholder="Password">
              </div>

              <div class="col-sm-12 text-center">
                <button type="submit" style="margin-top: 10%; margin-bottom: 10%" class="btn btn-primary" name="login">Login</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-sm-1" style="min-width: 10%"></div>

          <!-- Registration -->
          <!-- Variables
            email
            username
            firstname
            lastname
            password_register
            password_again
            date_of_birth
          -->
        <div class="col-sm-3" style="min-width: 200px">
          <form class="form" method="post" action="/~<?php echo $dbusername ?>/register.php">
            <div class="panel panel-default">
              <p class="text-center" style="font-size:150%">Registration</p>
              <label for="email" class="col-sm-12 col-form-label" style="font-size:120%">E-mail:</label>
              <div class="col-sm-12">
                <input class="form-control" style="font-size:90%" type="text" value="" id="email" name="email" onkeyup="email_func()" maxlength="32" placeholder="E-mail">
              </div>

              <label for="username" class="col-sm-12 col-form-label" style="font-size:120%">Username:</label>
              <div class="col-sm-12">
                <input class="form-control" style="font-size:90%" type="text" value="" id="username" name="username" onkeyup="username_func()" maxlength="16" placeholder="Username">
              </div>

              <label for="firstname" class="col-sm-12 col-form-label" style="font-size:120%">First Name:</label>
              <div class="col-sm-12">
                <input class="form-control" style="font-size:90%" type="text" value="" id="firstname" name="firstname" onkeyup="firstname_func()" maxlength="16" placeholder="First Name">
              </div>

              <label for="lastname" class="col-sm-12 col-form-label" style="font-size:120%">Last Name:</label>
              <div class="col-sm-12">
                <input class="form-control" style="font-size:90%" type="text" value="" id="lastname" name="lastname" onkeyup="lastname_func()" maxlength="16" placeholder="Last Name">
              </div>

              <label for="password_register" class="col-sm-12 col-form-label" style="font-size:120%">Password:</label>
              <div class="col-sm-12">
                <input class="form-control" style="font-size:90%" type="password" value="" id="password_register" name="password_register" maxlength="16" placeholder="Password">
              </div>

              <label for="password_again" class="col-sm-12 col-form-label" style="font-size:120%">Password (Again):</label>
              <div class="col-sm-12">
                <input class="form-control" style="font-size:90%" type="password" value="" id="password_again" name="password_again" maxlength="16" placeholder="Password (Again)">
              </div>

              <label for="date_of_birth" class="col-sm-12 col-form-label" style="font-size:120%">Date of Birth:</label>
              <div class="col-sm-12">
                <input class="form-control" style="font-size:90%" type="text" value="" id="date_of_birth" name="date_of_birth" onkeyup="date_of_birth_func()" maxlength="10" placeholder="YYYY-MM-DD">
              </div>

              <div class="col-sm-12 text-center">
                <button type="submit" style="margin-top: 10%; margin-bottom: 10%" class="btn btn-primary" name="register">Register</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script language="JavaScript" type="text/javascript">
    function email_or_username_func(){
      var email_or_username_func_value = document.getElementById("email_or_username").value;
      var new_email_or_username_func_value = email_or_username_func_value.replace(/\s+/g, '').replace(/[^_.@a-zA-Z0-9-\ ]+/g, '');

      document.getElementById("email_or_username").value = new_email_or_username_func_value;
    }

    function email_func(){
      var email_value = document.getElementById("email").value;
      var new_email_value = email_value.replace(/\s+/g, '').replace(/[^_.@a-zA-Z0-9-\ ]+/g, '');

      document.getElementById("email").value = new_email_value;
    }

    function username_func(){
      var username_value = document.getElementById("username").value;
      var new_username_value = username_value.replace(/\s+/g, '').replace(/[^_.a-zA-Z0-9-\ ]+/g, '');

      document.getElementById("username").value = new_username_value;
    }

    function firstname_func(){
      var firstname_value = document.getElementById("firstname").value;
      var new_firstname_value = firstname_value.replace(/\s+/g, '').replace(/[^a-zA-Z\ ]+/g, '');

      document.getElementById("firstname").value = new_firstname_value;
    }

    function lastname_func(){
      var lastname_value = document.getElementById("lastname").value;
      var new_lastname_value = lastname_value.replace(/\s+/g, '').replace(/[^a-zA-Z\ ]+/g, '');

      document.getElementById("lastname").value = new_lastname_value;
    }

    function date_of_birth_func(){
      var date_of_birth_value = document.getElementById("date_of_birth").value;
      var new_date_of_birth_value = date_of_birth_value.replace(/\s+/g, '').replace(/[^0-9\ ]+/g, '');

      if(new_date_of_birth_value.length > 4){
        new_date_of_birth_value = new_date_of_birth_value.substring(0, 4) + "-" + new_date_of_birth_value.substring(4, new_date_of_birth_value.length);
      }

      if(new_date_of_birth_value.length > 7){
        new_date_of_birth_value = new_date_of_birth_value.substring(0, 7) + "-" + new_date_of_birth_value.substring(7, new_date_of_birth_value.length);
      }

      if(new_date_of_birth_value.length > 10){
        new_date_of_birth_value = new_date_of_birth_value.substring(0,10);
      }

      if(new_date_of_birth_value.substring(5, 7) > 12){
        new_date_of_birth_value = new_date_of_birth_value.substring(0, 5) + "12" + new_date_of_birth_value.substring(7, new_date_of_birth_value.length);
      }

      if(new_date_of_birth_value.substring(8, 10) > 31){
        new_date_of_birth_value = new_date_of_birth_value.substring(0, 8) + "31";
      }

      document.getElementById("date_of_birth").value = new_date_of_birth_value;
    }
    </script>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>
