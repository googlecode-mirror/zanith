<?php
// The activasion hash, to be sent to the users' email
function createActhash($user, $pass, $RAND_KEY) {
  return md5($RAND_KEY.$user.$pass);
}

// The function to check if a user already exists
function userExists($user, $con) {
  $result = mysql_query("SELECT username FROM USER")or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");
  while($row = mysql_fetch_array($result)) {
     if($row[0]==$user) {
      $exists=true;
    } else {
      $exists=false;
    }
  } 
  mysql_free_result($result)or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");
  unset($result);
  unset($row);
  return $exists;
}

// The function to create a new user
function createNewuser($user, $password, $email, $ip, $acthash, $con) {
  mysql_query("INSERT INTO USER (username, password) VALUES ('".$user."', '".$password."')")or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");
  $result=mysql_query("SELECT UID FROM USER WHERE username='".$user."'");
  $uid=mysql_fetch_row($result);
  mysql_free_result($result)or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");
  $query="INSERT INTO ACCCREATE (uid, createdate, createtime, createip, activasionhash) VALUES (".$uid[0].", CURDATE(), CURTIME(),'".$ip."', '".$acthash."')";
  mysql_query($query)or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");
  $query="INSERT INTO ACCPROFILE (uid, displayname, email, currentip) VALUES (".$uid[0].", '".$user."', '".$email."','".$ip."')";
  mysql_query($query)or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");
  // -- CHANGE THESE --
  $mail_content="A user has registered an account at www.scaryinter.net if you wish to activate this account, please click the following link\n\t www.scaryinter.net/index.php?page=activasion&act=".$acthash;
  $mail_headers = "From: noreply@scaryinter.net";
  mail($email, "Profile Registration", $mail_content, $mail_headers);
  return true;
}

// Check the activasion hash on act.php
function checkAct($acthash) {
  $actbool=false;
  $query="SELECT activasionhash, accapprove FROM ACCCREATE";
  $result=mysql_query($query)or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");
  while($row = mysql_fetch_array($result)) {
    if($row[0]==$acthash && $row[1]==0) {
      $query="UPDATE ACCCREATE SET accapprove=1 WHERE activasionhash='".$acthash."'";
      mysql_query($query)or die("An error has occured, please report this error message the the administrator:<br /> <font color=\"red\">".mysql_error()."</font>");;
      return true;
    } else {
      $actbool=false;
    }
  } 
  return $actbool;  
}
?>
