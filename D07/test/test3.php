<?php
class Mere
{
  public static function lancerLeTest()
  {
    static::quiEstCe(); // self:: appelle la mere, static:: appelle la fille
  }

  public static function quiEstCe()
  {
    echo 'Je suis la classe <strong>Mere</strong> !';
  }
}

class Enfant extends Mere
{
  public static function quiEstCe()
  {
    echo 'Je suis la classe <strong>Enfant</strong> !';
  }
}

Enfant::lancerLeTest(); // appelle de la fonction de la classe fille

?>
