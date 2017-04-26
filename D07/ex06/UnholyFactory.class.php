<?php

include "Fighter.class.php";

class UnholyFactory {

  private $_soldiers = array();

  public function absorb($who) {
    if ($who instanceof Fighter and in_array($who, $this->_soldiers) == false) {
        $this->_soldiers[] = $who;
        echo "(Factory absorbed a fighter of type " . $who->name . ")\n";
    }
    else if ($who instanceof Fighter == false) {
      echo "(Factory can't absorb this, it's not a fighter)\n";
    }
    else if (in_array($who, $this->_soldiers)) {
      echo "(Factory already absorbed a fighter of type " . $who->name . ")\n";
    }
  }

  public function fabricate($who) {
    foreach ($this->_soldiers as $obj) {
      if ($obj->name == $who) {
        echo "(Factory fabricates a fighter of type " . $who . ")\n";
        return $obj;
      }
    }
    echo "(Factory hasn't absorbed any fighter of type " . $who . ")\n";
  }

}

 ?>
