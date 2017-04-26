#!/usr/bin/php
<?php

function ft_split($str) {
  $array = explode(' ', $str);
  $split = array();
  foreach ($array as $value) {
    if ($value != "")
      $split[] = $value;
  }
  sort($split, SORT_STRING);
  return $split;
}

unset($argv[0]);
$array = array();
foreach ($argv as $value) {
  $split = ft_split(trim($value));
  $array = array_merge($array, $split);
}
sort($array, SORT_STRING);
foreach ($array as $value) {
    echo $value . "\n";
}

?>
