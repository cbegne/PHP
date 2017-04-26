<?php

abstract class Fighter {

  public $name;

  abstract public function fight($t);

  public function __construct($who) {
    $this->name = $who;
  }

}

 ?>
