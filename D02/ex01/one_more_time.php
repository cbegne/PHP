#!/usr/bin/php
<?php

function get_month($month) {
  $tab_month = array(1 => "janvier", 2 => "février", 3 => "mars", 4 => "avril", 5 => "mai", 6 => "juin", 7 => "juillet", 8 => "août", 9 => "septembre", 10 => "octobre", 11 => "novembre",
  12 => "décembre");
  foreach ($tab_month as $key => $value) {
      if ($month == $value)
        return ($key);
  }
}

if ($argc > 1) {
  $array = preg_split("/[ ]/", $argv[1]);
  if (count($array) == 5) {
    $weekday = $array[0];
    if (preg_match("/^[lL]undi$|^[mM]ardi$|^[mM]ercredi$|^[jJ]eudi$|^[vV]endredi$|^[sS]amedi$|^[dD]imanche$/", $weekday) != 1)
      exit ("Wrong format\n");
    $day_number = $array[1];
    if (preg_match("/^[0-9]{1,2}$/", $day_number) != 1)
      exit ("Wrong format\n");
    $month = $array[2];
    if (preg_match("/^[jJ]anvier$|^[fF]évrier$|^[mM]ars$|^[aA]vril$|^[mM]ai$|^[jJ]uin$|^[jJ]uillet$|^[aA]oût$|^[sS]eptembre$|^[oO]ctobre$|^[nN]ovembre$|^[dD]écembre$/", $month) != 1)
      exit ("Wrong format\n");
    $year = $array[3];
    if (preg_match("/^[0-9]{4}$/", $year) != 1)
      exit ("Wrong format\n");
    $month_number = get_month(lcfirst($month));
    $time = preg_split("/:/", $array[4]);
    $hour = $time[0];
    $minute = $time[1];
    $second = $time[2];
    date_default_timezone_set('Europe/Paris');
    $result = mktime($hour, $minute, $second, $month_number, $day_number, $year);
    echo $result . "\n";
  }
  else
    echo "Wrong format\n";
}

?>
