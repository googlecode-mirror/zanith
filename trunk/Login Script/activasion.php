<?php
include('lib/includeall.php');
input_safe('null');
if(isset($_REQUEST["act"])) { $p_username=$_REQUEST["act"]; } else { die("One of the fields has not been set, please try again."); };
$con=mysql_start();
if(checkAct($_REQUEST["act"])) {
  echo "Account succesfully approved";
} else {
  echo "A problem has occured<br />Either the click you entered was invalid, or you are already activated, please check your link and try again.";
  
}
page_done($con);
?>