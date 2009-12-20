<?php
include('lib/includeall.php');
input_safe('null');
if(isset($_REQUEST["username"])) { $p_username=$_REQUEST["username"]; } else { die("One of the fields has not been set, please try again."); };
if(isset($_REQUEST["password"])) { $p_password=$_REQUEST["password"]; } else { die("One of the fields has not been set, please try again."); };
if(isset($_REQUEST["email"])) { $p_email=$_REQUEST["email"]; } else { die("One of the fields has not been set, please try again."); };
$createip=$_SERVER["REMOTE_ADDR"];
$acthash=createActhash($p_username, $p_password, $RAND_KEY);
$con=mysql_start();
if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $p_email)) {
  die("The email you have entered is invalid, please try again with a valid email");
}
if(userExists($p_username, $con)) {
  die("User already exists, please try again");
} else {

  if(createNewuser($p_username, $p_password, $p_email, $createip, $acthash, $con)) {
    echo "New user account has been created, please check your email account and click on the activation link provided";
  }
}
page_done($con);
?>

