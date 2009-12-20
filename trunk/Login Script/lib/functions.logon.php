<?php
function logonCheck($user, $pass) {
  $result = mysql_query("SELECT password FROM USER WHERE username='".$user."'")or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");
  $row = mysql_fetch_row($result);
     if($row[0]==$pass) {
      if(!isAct($user)) {
        die("The username you are trying to log into, is not currently activated, please access your email and click the activation link");
      }
      $exists=true;
      startLogin($user);
    } else {
      $exists=false;
    }
   
  mysql_free_result($result)or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");
  unset($result);
  unset($row);
  return $exists;
}

function startLogin($user) {
  if(!isset($_SESSION["uid"])) { 
  session_start();
  if (!isset($_COOKIE["profile_sid"])) {
    setcookie("profile_sid", session_id(), time()+864000);
  }
  $result=mysql_query("SELECT UID FROM USER WHERE username='".$user."'")or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");;
  $uid=mysql_fetch_row($result);
  $result=mysql_query("SELECT displayname FROM ACCPROFILE INNER JOIN USER ON ACCPROFILE.uid=USER.uid WHERE username='".$user."'")or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");;
  $displayname=mysql_fetch_row($result);
  $_SESSION["uid"]=$uid[0];
  $_SESSION["displayname"]=$displayname[0];
  Header("Location: index.php");
  return 0;
  }
}

function isAct($user) {
  $result=mysql_query("SELECT accapprove FROM ACCCREATE INNER JOIN USER ON ACCCREATE.uid=USER.uid WHERE username='".$user."'")or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");
  $activated=mysql_fetch_row($result);
  return $activated[0];
}

function isLoggedOn($sessionkey, $ip) {
  return 0;
}

function endLogon() {
  setcookie("profile_sid", session_id(), time()-864000);
  if(isset($_SESSION["uid"])) {
    session_destroy();
  }
  Header("Location: index.php");
  return true;
}
?>