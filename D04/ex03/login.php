<?php

include 'auth.php';

session_start();
$login = $_GET['login'];
$passwd = $_GET['passwd'];
if ($login && $passwd && $_GET['submit'] == 'OK') {
   if (auth($login, $passwd) === TRUE) {
     $_SESSION['logged_on_user'] = $login;
     echo "OK\n";
   }
   else {
     $_SESSION['logged_on_user'] = "";
     echo "ERROR\n";
   }
 }
else {
  echo "ERROR\n";
}

?>
