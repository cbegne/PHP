#!/usr/bin/php
<?php

if ($argc > 1) {
  $str = trim($argv[1], " \t");
  $print = preg_replace("/[ \t]+/", " ", $str);
  echo $print . "\n";
}

?>
