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

function get_adjusted_ord($char) {
	$ascii = ord($char);
	if ($ascii == 0)
		return $ascii;
	if (($ascii < 48) || ($ascii >= 91 && $ascii <= 96) || ($ascii > 122))
		$ascii += 1000;
	else if ($ascii >= 48 && $ascii <= 57)
		$ascii += 100;
	else if ($ascii >= 65 && $ascii <= 90)
		$ascii += 32;
	return $ascii;
}

function ssap2_cmp($str1, $str2) {
  for ($i = 0; $i < strlen($str1) && $i < strlen($str2); $i++) {
    $nb1 = get_adjusted_ord($str1[$i]);
    $nb2 = get_adjusted_ord($str2[$i]);
    if ($nb1 != $nb2)
      return ($nb1 < $nb2) ? -1 : 1;
  }
  if (strlen($str1) == strlen($str2))
    return 0;
  return strlen($str1) < strlen($str2) ? -1 : 1;
}

unset($argv[0]);
$array = array();
foreach ($argv as $value) {
	$split = ft_split($value);
	$array = array_merge($array, $split);
}
usort($array, "ssap2_cmp");
foreach ($array as $value) {
  echo $value . "\n";
}

?>
