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

?>
