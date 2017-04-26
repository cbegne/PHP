#!/usr/bin/php
<?php

function ft_split($str) {
  $array = explode(' ', $str);
  $split = array();
  foreach ($array as $value) {
    if ($value != "")
      $split[] = $value;
  }
  return $split;
}

if ($argc > 1 && strlen(trim($argv[1])) > 0) {
  $array = ft_split(trim($argv[1]));
  $first = $array[0];
  unset($array[0]);
  foreach ($array as $value) {
    echo $value . " ";
  }
  echo $first . "\n";
}

?>
