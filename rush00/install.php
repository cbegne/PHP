<?php

session_start() or die("Failed to resume session\n");
session_unset();
$_SESSION["loggued_on_user"] = "Guest";
$_SESSION["admin"] = false;
$_SESSION['need_auth'] = false;

$conn = mysqli_connect("localhost"); // MDP
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$db = 'db';

$sql = "DROP DATABASE " . $db; // Suppr
mysqli_query($conn, $sql); // Suppr

$sql = "CREATE DATABASE " . $db;
mysqli_query($conn, $sql);

mysqli_query($conn, "USE " . $db);

$sql = "CREATE TABLE IF NOT EXISTS `produits` (
  `id_produit` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nom_produit` VARCHAR(255) NOT NULL,
  `prix` FLOAT UNSIGNED NOT NULL,
  `img` VARCHAR(255) NOT NULL)";
mysqli_query($conn, $sql);

$sql = "INSERT INTO `produits` (`nom_produit`, `prix`, `img`) VALUES ('banane', 1, 'http://www.icone-png.com/png/13/13081.png'), ('pomme', 1.5, 'http://www.solyimport.com/wp-content/uploads/2014/01/Pomme_Soly-Import-3.png'), ('orange', 2, 'http://pngimg.com/uploads/orange/orange_PNG786.png'), ('cocombre', 1, 'http://fran6.deport.free.fr/dotclear/public/concombre.png'), ('avocat', 3, 'http://www.synergiealimentaire.com/momo/uploads/2014/02/avocat-synergie-alimentaire.png')";
mysqli_query($conn, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `user` (
  `id_user` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `login` VARCHAR(11) NOT NULL,
  `mdp` VARCHAR(255) NOT NULL,
  `is_admin` BOOLEAN NOT NULL)";
mysqli_query($conn, $sql);

$sql = "INSERT INTO `user` (`login`, `mdp`, `is_admin`) VALUES ('root', '06948d93cd1e0855ea37e75ad516a250d2d0772890b073808d831c438509190162c0d890b17001361820cffc30d50f010c387e9df943065aa8f4e92e63ff060c', 1), ('Guest', '06948d93cd1e0855ea37e75ad516a250d2d0772890b073808d831c438509190162c0d890b17001361820cffc30d50f010c387e9df943065aa8f4e92e63ff060c', 0)";
mysqli_query($conn, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `categories` (
  `id_cat` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nom_cat` VARCHAR(255) NOT NULL)";
mysqli_query($conn, $sql);

$sql = "INSERT INTO `categories` (`nom_cat`) VALUES ('all'), ('fruit'), ('legume'), ('bio')";
mysqli_query($conn, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `produits_categories` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nom_produit` VARCHAR(255) NOT NULL,
  `nom_cat` VARCHAR(255) NOT NULL)";
mysqli_query($conn, $sql);

$sql = "INSERT INTO `produits_categories` (`nom_produit`, `nom_cat`) VALUES ('banane', 'all'), ('banane', 'fruit'), ('banane', 'bio'), ('pomme', 'all'), ('pomme', 'fruit'), ('orange', 'all'), ('orange', 'fruit'), ('cocombre', 'all'), ('cocombre', 'legume'), ('avocat', 'all'), ('avocat', 'legume'), ('avocat', 'bio')";
mysqli_query($conn, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nom_produit` VARCHAR(255) NOT NULL,
  `quantite` INT NOT NULL,
  `login` VARCHAR(11) NOT NULL)";
mysqli_query($conn, $sql);

mysqli_close($conn);
?>
