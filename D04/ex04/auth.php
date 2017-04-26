<?php

function auth($login, $passwd) {
  $dir = "../private";
  $file = $dir . "/passwd";
  $list_serialized = file_get_contents($file);
  $list = unserialize($list_serialized);
  $passwd_hash = hash('whirlpool', $passwd);
  foreach ($list as $tab) {
    if ($tab['login'] === $login && $tab['passwd'] === $passwd_hash)
      return TRUE;
  }
  return FALSE;
}

?>
