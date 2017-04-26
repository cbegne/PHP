#!/usr/bin/php
<?php

require "ft_is_sort.php";

// $tab = array("!@^:", "42", "Hello world", "toto");
// $tab[] = "x123abcd";
$tab = array("z", "xxx", "ttt", "hhh");
if (ft_is_sort($tab))
  echo "Le tableau est trie\n";
else
  echo "Le tableau n'est pas trie\n";

?>
