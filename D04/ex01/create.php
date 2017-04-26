<?php

if ($_POST['login'] && $_POST['passwd'] && $_POST['submit'] == 'OK')
{
  $dir = "../private";
  $file = $dir . "/passwd";
  $login = $_POST['login'];
  $passwd = $_POST['passwd'];
  $passwd_hash = hash('whirlpool', $passwd);
  $person['login'] = $login;
  $person['passwd'] = $passwd_hash;
  if (file_exists($dir) === FALSE)
    mkdir($dir);
  if (file_exists($file) === TRUE)
  {
    $list_serialized = file_get_contents($file);
    $list = unserialize($list_serialized);
    if ($list !== FALSE) {
      foreach ($list as $tab) {
        if ($tab['login'] === $login) {
          echo "ERROR\n";
          return ;
        }
      }
    }
  }
  $list[] = $person;
  $list_serialized = serialize($list);
  file_put_contents($file, $list_serialized);
  echo "OK\n";
}
else {
  echo "ERROR\n";
}

?>
