<?php

	require 'connect.php';
	require 'check_db.php';

	session_start() or die("Failed to resume session\n");
	$conn = connect();

	$basket = $_SESSION['basket'];

	$array_cat = array();
	$query_cat = mysqli_query($conn, "SELECT * FROM `categories`");
	while (($array = mysqli_fetch_array($query_cat, MYSQLI_ASSOC)) !== NULL)
		$array_cat[] = $array['nom_cat'];

	if ($_GET['categorie'])
	{
		$array_produit = array();
		$produits_cat_selected = mysqli_real_escape_string($conn, $_GET['categorie']);
		$query_produits = mysqli_query($conn, "SELECT `nom_produit` FROM `produits_categories` WHERE `nom_cat` = '$produits_cat_selected'");
		while (($array = mysqli_fetch_array($query_produits, MYSQLI_ASSOC)) !== NULL)
			$array_produit[$array['nom_produit']] = 0;
		foreach ($array_produit as $nom_produit => $value)
		{
			$query_prix = mysqli_query($conn, "SELECT * FROM `produits` WHERE `nom_produit` = '$nom_produit'");
			$array = mysqli_fetch_array($query_prix, MYSQLI_ASSOC);
			$array_produit[$nom_produit] = array("prix" => $array['prix'], "img" => $array['img']);
		}
	}
	else
	{
		$query_produits = mysqli_query($conn, "SELECT * FROM `produits`");
		while (($array = mysqli_fetch_array($query_produits, MYSQLI_ASSOC)) !== NULL)
			$array_produit[$array['nom_produit']] = array("prix" => $array['prix'], "img" => $array['img']);
	}

	foreach ($array_produit as $nom_produit => $value)
	{
  		if (trim($_POST['quantite_' . $nom_produit]) && $_POST['submit_' . $nom_produit] == "OK")
		{
			$quantite = mysqli_real_escape_string($conn, trim($_POST['quantite_' . $nom_produit]));
			$login = $_SESSION["loggued_on_user"];
			$_SESSION['basket'][] = array("nom_produit" => $nom_produit, "quantite" => $quantite, "prix_unitaire" => $value['prix']);
			echo '<meta http-equiv="refresh" content="0;url=home.php">';
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
	<div class="categorie">
		<ul class="lst-inline align-left" >
			<?php
				foreach ($array_cat as $nom_cat)
					echo '<li><a class="tag" href="?categorie='.$nom_cat.'">'.$nom_cat.'</a></li>';
			?>
		</ul>
	</div>
		<div class="products">
			<ul class="card">
				<?php
					$img = "http://placehold.it/300x200";
					foreach ($array_produit as $nom_produit => $value)
					{
						echo '<li><img src="'.$value['img'].'" width=300 height=200>';
						echo '<form method="post" class="cart-form">';
						echo '<p class="cart-name">'.$nom_produit.'<p><hr><p>'.$value['prix'].' € TTC<p>';
						echo '<span>Quantité </span>';
						echo '<input type="number" name="quantite_'.$nom_produit.'" value="1" required="true" min="1" max="30">';
						echo '<br><br><button type="submit" name="submit_'.$nom_produit.'" value="OK" class="btn-cart">Ajouter au panier</button>';
						echo '</form>';
						echo '</li>';
					}
				?>
			</ul>
		</div>
	</div>
</body>
</html>