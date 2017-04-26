<?php

class NightsWatch {

  private $_recruited = array();

  public function recruit($who) {
    if ($who instanceof IFighter)
      $this->_recruited[] = $who;
  }

  public function fight() {
      foreach ($this->_recruited as $who) {
        $who->fight();
      }
  }

}

 ?>
