#!/usr/bin/php
<?php

if ($argc == 2 && strlen(trim($argv[1])) > 0) {
  $str = trim($argv[1]);
  $array = explode(' ', $str);
  foreach ($array as $key => $value) {
    if ($value != "") {
     echo $value;
    if ($key != count($array) - 1)
      echo " ";
    else
      echo "\n";
    }
  }
}

?>
