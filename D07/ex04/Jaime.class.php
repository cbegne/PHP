<?php

include_once('Lannister.class.php');

class Jaime extends Lannister {

  function sleepWith($who) {
    if ($who instanceof Stark) {
      echo "Let's do this.\n";
    }
    else if ($who instanceof Cersei) {
      echo "With pleasure, but only in a tower in Winterfell, then.\n";
    }
    else if ($who instanceof Lannister) {
      echo "Not even if I'm drunk !\n";
    }
  }

}

?>
