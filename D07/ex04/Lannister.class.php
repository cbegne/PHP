<?php

class Lannister {

  function sleepWith($who) {
    if ($who instanceof Stark) {
      echo "Let's do this.\n";
    }
    else if ($who instanceof Lannister) {
      echo "Not even if I'm drunk !\n";
    }
  }

}

 ?>
