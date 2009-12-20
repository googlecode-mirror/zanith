<?php
// Parse malicious input, unless specific otherwise.
function input_safe($safe_val) {
  if(array_key_exists($safe_val, $_REQUEST)) {
    $SAFE_ARR=array($safe_val => $_REQUEST[$safe_val]);
  foreach ($_REQUEST as $strip_name => $strip_value) {
      $strip_value = htmlentities(strip_tags($strip_value), ENT_QUOTES);
  }
  return(array_merge($_REQUEST, $SAFE_ARR));
  }
  unset($strip_value);
  unset($safe_val);
  unset($SAFE_ARR);
}

// Things to do, after everything on the page has finished executing.
function page_done($mysql_con) {
  if($mysql_con) { mysql_close($mysql_con); };
}
?>