<!-- Gestion admin => ajout, modif, suppr -->

<?php

session_start() or die("Failed to resume session\n");

require 'connect.php';
require 'check_db.php';

$conn = connect();

$basket = $_SESSION['basket'];


if (trim($_POST['command_user']) && $_POST['submit_command_user'] == 'OK')
{
    $user_valid = $_POST['command_user']."_valid";
    if ($_SESSION[$user_valid])
		  echo '<meta http-equiv="refresh" content="0;url=panier.php?user='.$_POST['command_user'].'">';
}

if ($_SESSION['admin'] == false)
    echo '<meta http-equiv="refresh" content="0;url=home.php">';
$sql = "SELECT `nom_produit` FROM `produits`";
$result = mysqli_query($conn, $sql);
$array_produit = array();
while ($array = mysqli_fetch_array($result)) {
  $array_produit[] = $array['nom_produit'];
}
$sql = "SELECT `nom_cat` FROM `categories`";
$result = mysqli_query($conn, $sql);
$array_cat = array();
while ($array = mysqli_fetch_array($result)) {
  $array_cat[] = $array['nom_cat'];
}

if (trim($_POST['ajout_nom']) && trim($_POST['ajout_prix']) && trim($_POST['ajout_cat']) && trim($_POST['ajout_img']) && $_POST['submit_ajout_produit'] == 'OK') {
  $nom = mysqli_real_escape_string($conn, trim($_POST['ajout_nom']));
  $prix = mysqli_real_escape_string($conn, trim($_POST['ajout_prix']));
  $cat = mysqli_real_escape_string($conn, trim($_POST['ajout_cat']));
  $img = mysqli_real_escape_string($conn, trim($_POST['ajout_img']));
  if (check_exist($conn, '`produits`', '`nom_produit`', $nom) == 1)
    echo "Product already exists";
  else if (check_exist($conn, '`categories`', '`nom_cat`', $cat) == 0)
    echo "Category does not exist";
  else {
    $sql = "INSERT INTO `produits` (`nom_produit`, `prix`, `img`) VALUES ('$nom', '$prix', '$img')";
    if (mysqli_query($conn, $sql))
      echo "Product created";
    else
      echo "Error";
    $sql = "INSERT INTO `produits_categories` (`nom_produit`, `nom_cat`) VALUES ('$nom' , '$cat')";
    if (mysqli_query($conn, $sql))
      echo " with correct category";
    else
      echo " but problem with category";
    if ($nom_cat != 'all') {
      $sql = "INSERT INTO `produits_categories` (`nom_produit`, `nom_cat`) VALUES ('$nom' , 'all')";
      mysqli_query($conn, $sql);
    }
  }
}

if (trim($_POST['modif_nom']) && trim($_POST['modif_prix']) && $_POST['submit_modif_produit'] == 'OK') {
  $nom = mysqli_real_escape_string($conn, trim($_POST['modif_nom']));
  $new_price = mysqli_real_escape_string($conn, trim($_POST['modif_prix']));
  if (check_exist($conn, '`produits`', '`nom_produit`', $nom) == 0)
    echo "No product with this name";
  else {
    $sql = "UPDATE `produits` SET `prix` = $new_price WHERE `nom_produit` = '$nom'";
    if (mysqli_query($conn, $sql))
      echo "Updated";
    else
      echo "Error";
  }
}

if (trim($_POST['suppr_nom_produit']) && $_POST['submit_suppr_produit'] == 'OK') {
  $nom = mysqli_real_escape_string($conn, trim($_POST['suppr_nom_produit']));
  if (check_exist($conn, '`produits`', '`nom_produit`', $nom) == 0)
    echo "No product with this name";
  else {
  $sql = "DELETE FROM `produits` WHERE `nom_produit` = '$nom'";
  if (mysqli_query($conn, $sql))
    echo "Deleted";
  else
    echo "Error";
  $sql = "DELETE FROM `produits_categories` WHERE `nom_produit` = '$nom'";
  mysqli_query($conn, $sql);
  }
}

if (trim($_POST['ajout_categorie']) && $_POST['submit_ajout_cat'] == 'OK') {
  $cat = mysqli_real_escape_string($conn, trim($_POST["ajout_categorie"]));
  if (check_exist($conn, '`categories`', '`nom_cat`', $cat) == 1)
  	echo "Category already exists";
  else {
  	$sql = "INSERT INTO `categories` (`nom_cat`) VALUES ('$cat')";
  	if (mysqli_query($conn, $sql))
  		echo "Category created";
  	else
  		echo "Error";
  }
}

if ($_POST['ajout_cat_produit'] && $_POST['ajout_cat_cat'] && $_POST['submit_ajout_cat_produit'] == 'OK') {
  $produit = $_POST['ajout_cat_produit'];
  $cat = $_POST['ajout_cat_cat'];
  $sql = "INSERT INTO `produits_categories` (`nom_produit`, `nom_cat`) VALUES ('$produit' ,'$cat')";
  if (mysqli_query($conn, $sql))
    echo "Category added";
  else
    echo "Error";
}

if (trim($_POST['suppr_cat']) && $_POST['submit_suppr_cat'] == 'OK') {
  $cat = mysqli_real_escape_string($conn, trim($_POST['suppr_cat']));
  if (check_exist($conn, '`categories`', '`nom_cat`', $cat) == 0)
    echo "No categorie with this name";
  else if ($cat == 'all')
    echo "Cannot delete 'all'";
  else {
  $sql = "DELETE FROM `categories` WHERE `nom_cat` = '$cat'";
  if (mysqli_query($conn, $sql))
    echo "Deleted";
  else
    echo "Error";
  }
}


if (trim($_POST['ajout_login']) && trim($_POST['ajout_mdp']) && $_POST['ajout_admin'] && $_POST['submit_ajout_user'] == 'OK') {
  $login = mysqli_real_escape_string($conn, trim($_POST["ajout_login"]));
  if (check_exist($conn, '`user`', '`login`', $login) == 1)
  	echo "login already used";
  else {
  	$passwd = mysqli_real_escape_string($conn, trim($_POST["ajout_mdp"]));
    $admin = $_POST["ajout_admin"];
    if ($admin == "oui")
      $admin = "1";
    else
      $admin = "0";
  	$passwd_hash = hash('whirlpool', $passwd);
  	$sql = "INSERT INTO `user` (`login`, `mdp`, `is_admin`) VALUES ('$login', '$passwd_hash', $admin)";
  	if (mysqli_query($conn, $sql))
  		echo "User created";
  	else
  		echo "Error";
  }
}

if (trim($_POST['suppr_user']) && $_POST['submit_suppr_user'] == 'OK') {
  $login = mysqli_real_escape_string($conn, trim($_POST['suppr_user']));
  if (check_exist($conn, '`user`', '`login`', $login) == 0)
    echo "No user with this login";
  else if ($login == 'root')
    echo "Cannot delete 'root'";
  else {
  $sql = "DELETE FROM `user` WHERE `login` = '$login'";
  if (mysqli_query($conn, $sql))
    echo "Deleted";
  else
    echo "Error";
  }

}

mysqli_close($conn);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fruit42</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
</head>
<body>
	<div class="header">
		<div class="menu">
			<a href="home.php" class="align-left"><img src="img/logo.png" height=100% width="150"></a>
			<ul class="lst-inline align-right">
				<li><span>Bonjour<br><?=$_SESSION['loggued_on_user']?></span></li>
        <?php
					$total = 0;
					$count = 0;
					if ($basket)
					foreach ($basket as $command_line)
					{
						$total = $total + $command_line['quantite'] * $command_line['prix_unitaire'];
						$count = $count + $command_line['quantite'];
					}
					echo '<li><a href="panier.php">Panier</a></li>';
					echo ' ( '.$count.' | '.$total.' €)';
				?>
				<?php if($_SESSION['loggued_on_user'] !== "Guest"): ?>
            		<li><a href="modif.php">Mon Compte</a></li>
            		<li><a href="logout.php">Deconnexion</a></li>
				<?php else: ?>
            		<li><a href="login.php">Connexion</a></li>
				<?php endif; ?>
				<?php if($_SESSION['admin'] === true): ?>
            		<li><a href="admin.php">Administrator</a></li>
				<?php endif; ?>	
			</ul>			
		</div>
	</div>
  <div class="content">	
		<div class="login">
      <h2 class="text-center">Mes Produits</h2><br>
      <h3 class="text-center">Creation produit</h3><br>
      <form method="post" class="form">
          Nom<br><input type="text" name="ajout_nom" value=""><br />
          Prix<br><input type="number" min="0" step="0.5" name="ajout_prix" value=""><br />
          Categorie Initial<br><input type="text" name="ajout_cat" value=""><br />
          Image<br><input type="text" name="ajout_img" value=""><br />
          <input type="submit" name="submit_ajout_produit" value="OK" class="btn-input">
			</form>
      <h3 class="text-center">Modification produit</h3><br>
      <form method="post" class="form">
        Nom<br><input type="text" name="modif_nom" value=""><br />
        Nouveau prix<br><input type="number" min="0" step="0.5" name="modif_prix" value=""><br />
        <input type="submit" name="submit_modif_produit" value="OK" class="btn-input">
      </form>
      <h3 class="text-center">Suppression produit</h3><br>
      <form method="post" class="form">
        Nom<br><input type="text" name="suppr_nom_produit" value=""><br />
        <input type="submit" name="submit_suppr_produit" value="OK" class="btn-input">
      </form>
      <h2 class="text-center"><hr>Mes categories</h2><br>
      <h3 class="text-center">Creation categorie</h3><br>
      <form method="post" class="form">
        Nom<br><input type="text" name="ajout_categorie" value=""><br />
        <input type="submit" name="submit_ajout_cat" value="OK" class="btn-input">
      </form>
      <h3 class="text-center">Ajouter une categorie a un produit</h3><br>
      <form method="post" class="form">
        Produit<br><select name="ajout_cat_produit">
          <?php foreach ($array_produit as $value) { ?>
            <option value="<?=$value?>"><?=$value?></option>
          <?php } ?>
        </select><br />
        Categorie<br><select name="ajout_cat_cat">
        <?php foreach ($array_cat as $value) { ?>
          <option value="<?=$value?>"><?=$value?></option>
        <?php } ?>
      </select><br />
      </select><br />
      <input type="submit" name="submit_ajout_cat_produit" value="OK" class="btn-input"><br/>
      </form>
      <h3 class="text-center">Suppression categorie</h3><br>
      <form method="post" class="form">
        Nom<br><input type="text" name="suppr_cat" value=""><br />
        <input type="submit" name="submit_suppr_cat" value="OK" class="btn-input">
      </form>
      <h2 class="text-center"><hr>Utilisateurs</h2><br>
      <h3 class="text-center">Creation utilisateur</h3><br>
      <form method="post" class="form">
        Identifiant<br><input type="text" name="ajout_login" value=""><br />
        Mot de passe<br><input type="text" name="ajout_mdp" value=""><br />
        Administrateur<br>
      <select name="ajout_admin">
        <option value="non">Non</option>
        <option value="oui">Oui</option>
      </select><br />
      <input type="submit" name="submit_ajout_user" value="OK" class="btn-input">
      </form>
      <h3 class="text-center">Suppression utilisateur</h3><br>
      <form method="post" class="form">
        Identifiant<br><input type="text" name="suppr_user" value=""><br />
        <input type="submit" name="submit_suppr_user" value="OK" class="btn-input">
      </form>
      <h3 class="text-center">Gerer les commandes</h3><br>
      <form method="post" class="form">
        Identifiant<br><input type="text" name="command_user" value=""><br />
        <input type="submit" name="submit_command_user" value="OK" class="btn-input">
      </form>
  </body>
</html>