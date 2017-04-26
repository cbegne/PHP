<?php

if ($_GET['action'] == 'set' && $_GET['name']) {
  setcookie($_GET['name'], $_GET['value'], time() + 365*24*3600);
}
else if ($_GET['action'] == 'get' && $_GET['name']) {
  $name = $_GET['name'];
  if (isset($_COOKIE[$name]))
    echo $_COOKIE[$name] . "\n";
}
else if ($_GET['action'] == 'del' && $_GET['name']) {
  setcookie($_GET['name'], "", time() - 3600);
}

?>
