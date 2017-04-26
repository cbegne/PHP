<?php

if ($_POST['login'] && $_POST['oldpw'] && $_POST['newpw'] && $_POST['submit'] == 'OK')
{
  $dir = "../private";
  $file = $dir . "/passwd";
  $login = $_POST['login'];
  $oldpw = $_POST['oldpw'];
  $newpw = $_POST['newpw'];
  $oldpw_hash = hash('whirlpool', $oldpw);
  $newpw_hash = hash('whirlpool', $newpw);
  $list_serialized = file_get_contents($file);
  $list = unserialize($list_serialized);
  if ($list !== FALSE) {
    foreach ($list as $key => $tab) {
      if ($tab['login'] === $login && $tab['passwd'] === $oldpw_hash) {
        $list[$key]['passwd'] = $newpw_hash;
        $list_serialized = serialize($list);
        file_put_contents($file, $list_serialized);
        echo "OK\n";
        return ;
      }
    }
  }
}
echo "ERROR\n";

?>
