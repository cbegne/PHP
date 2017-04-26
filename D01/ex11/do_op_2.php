#!/usr/bin/php
<?php

function find_op($str) {

  if (($i = strpos($str, '+')) == TRUE)
    return $i;
  if (($i = strpos($str, '-')) == TRUE)
    return $i;
  if (($i = strpos($str, '*')) == TRUE)
    return $i;
  if (($i = strpos($str, '/')) == TRUE)
    return $i;
  if (($i = strpos($str, '%')) == TRUE)
    return $i;
  return 0;
}

if ($argc == 2)
{
  $input = trim($argv[1]);
  $i = find_op($input);
  if ($i == 0) {
    echo "Syntax Error\n";
    exit();
  }
  $val1 = trim(substr($input, 0, $i));
  $op = $input[$i];
  $val2 = trim(substr($input, $i + 1, strlen($input) - $i - 1));
  if (is_numeric($val1) == FALSE || is_numeric($val2) == FALSE) {
    echo "Syntax Error\n";
    exit();
  }
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
