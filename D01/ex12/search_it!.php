#!/usr/bin/php
<?php

if ($argc > 2) {
  unset($argv[0]);
  $data = $argv[1];
  unset($argv[1]);
  foreach ($argv as $key => $value) {
    $tab = explode(':', $value);
    if ($tab[0] == $data)
      $print = $tab[1];
  }
  if ($print != NULL)
    echo $print . "\n";
}

?>
