<?php
// Main SQL connection function
function mysql_start() {
include('vars.php');
$con = mysql_connect($mysql_host,$mysql_user,$mysql_pass);
if (!$con)
  {
    die('Could not connect: ' . mysql_error());
  }
  mysql_select_db("profiledb", $con)or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");
  return $con;
}
?>
