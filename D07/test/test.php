<?php

class Compteur
{
  private static $_compteur = 0;

  public function __construct(){
    self::$_compteur++;
  }

  public function getCompteur() {
    return self::$_compteur;
  }
}

$call1 = new Compteur;
$call2 = new Compteur;
$call3 = new Compteur;

echo Compteur::getCompteur();

?>
