<?php
include('lib/includeall.php');
input_safe('null');
if(isset($_REQUEST["username"])) { $p_username=$_REQUEST["username"]; } else { die("One of the fields has not been set, please try again."); };
if(isset($_REQUEST["password"])) { $p_password=$_REQUEST["password"]; } else { die("One of the fields has not been set, please try again."); };
$createip=$_SERVER["REMOTE_ADDR"];
$con=mysql_start();

if(logonCheck($p_username, $p_password)) {
  echo "Logon successful<br />";
  echo print_r($_SESSION);
} else { 
  echo "Logon error, invalid username or password";
}
page_done($con);
?>