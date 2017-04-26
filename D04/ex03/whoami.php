<?php

session_start();
$log = $_SESSION['logged_on_user'];
if ($log) {
  echo $log . "\n";
}
else {
  echo "ERROR\n";
  }

?>
