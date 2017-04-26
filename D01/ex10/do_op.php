#!/usr/bin/php
<?php

if ($argc == 4)
{
  $val1 = trim($argv[1]);
  $op = trim($argv[2]);
  $val2 = trim($argv[3]);
  if ($op == '+')
    $result = $val1 + $val2;
  elseif ($op == '-')
    $result = $val1 - $val2;
  elseif ($op == '*')
      $result = $val1 * $val2;
  elseif ($op == '/')
    $result = $val1 / $val2;
  elseif ($op == '%')
    $result = $val1 % $val2;
  echo $result . "\n";
}
else
  echo "Incorrect Parameters\n";

?>
