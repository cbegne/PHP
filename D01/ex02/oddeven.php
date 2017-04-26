#!/usr/bin/php
<?php

while (42)
{
  echo "Entrez un nombre: ";
  $line = trim(fgets(STDIN));
  if (feof(STDIN)) {
    echo "^D\n";
    exit();
  }
  if (is_numeric($line) == FALSE)
    echo "'$line' n'est pas un chiffre\n";
  else if ($line % 2 == 0)
    echo "Le chiffre ".$line." est Pair\n";
  else
    echo "Le chiffre ".$line." est Impair\n";
}

?>
