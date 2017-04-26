<?php

include 'auth.php';

session_start();
$login = $_POST['login'];
$passwd = $_POST['passwd'];
if ($login && $passwd && $_POST['submit'] == 'OK') {
   if (auth($login, $passwd) === TRUE) {
     $_SESSION['logged_on_user'] = $login;
     echo "<iframe name='chat' src='chat.php' width='100%' height='550px'></iframe>\n";
     echo "<iframe name='speak' src='speak.php' width='100%' height='50px'></iframe>\n";
     return ;
   }
   else {
     $_SESSION['logged_on_user'] = "";
   }
 }
echo "ERROR\n";

?>
