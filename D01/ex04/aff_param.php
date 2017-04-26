#!/usr/bin/php
<?php

foreach ($argv as $key => $value) {
    if ($key == 0)
      continue ;
    echo $value . "\n";
}

?>
