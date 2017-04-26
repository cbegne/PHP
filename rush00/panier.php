<?php

    require 'connect.php';

	session_start() or die("Failed to resume session\n");
	$conn = connect();

	$login = $_SESSION["loggued_on_user"];

	foreach ($_SESSION['basket'] as $key => $command_line)
		if ($_POST['suppr_' . $key] == "X")
			unset($_SESSION['basket'][$key]);

	$user_admin = ($_SESSION['admin'] and $_GET['user']) ? $_GET['user']."_valid" : 0;
	$basket = ($_SESSION['admin'] and $_GET['user']) ? $_SESSION[$user_admin]: $_SESSION['basket'];

	if ($_POST['valider'] == "Valider panier")
	{
		if ($login == "Guest" OR $login == NULL)
		{
			$_SESSION['need_auth'] = true;
			echo '<meta http-equiv="refresh" content="0;url=login.php">';
		}
		else
		{
			foreach ($basket as $command_line)
			{
				$nom_produit = $command_line['nom_produit'];
				$quantite = $command_line['quantite'];
				$sql = "INSERT INTO `commande` (`nom_produit`, `quantite`, `login`) VALUES ('$nom_produit', $quantite, '$login')";
				if (mysqli_query($conn, $sql))
					;//echo "Command created";
				else
					;//echo "Error";
			}
			$user_valid = $_SESSION["loggued_on_user"]."_valid"; 
			$_SESSION['need_auth'] = false;
			$_SESSION[$user_valid] = $basket;
			$_SESSION['Guest_basket'] = [];
		}
	}

?>

<html lang="en"><head>
	<meta charset="UTF-8">
	<title>My Shop</title>
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
		<div class="cart">
			<br><h2 class="text-center">Votre panier</h2><br>
			<form action="panier.php" method="post">
				<table>
					<tbody>
						<tr>
							<th class="cart-art align-left">Produit</th>
							<th class="cart-quantity">Quantité</th>
							<th class="cart-price">Prix</th>
						</tr>
						<?php
							$total = 0;
							$count = 0;
							if ($basket)
							foreach ($basket as $key => $command_line)
							{
								echo '<tr>';
								echo '<td class="cart-art">'.$command_line['nom_produit'].'</td>';
								echo '<td class="cart-quantity">'.$command_line['quantite'].'</td>';
								echo '<td class="cart-price">'.($command_line['quantite'] * $command_line['prix_unitaire']).' € TTC</td>';
								echo '<td class="cart-del"><button type="submit" name="suppr_'.$key.'" value="X" class="cart-del">X</button></td>';
								echo '</tr>';
      							$total = $total + $command_line['quantite'] * $command_line['prix_unitaire'];
								$count = $count + $command_line['quantite'];
							}
						?>
						<tr>
							<td class="cart-total">TOTAL</td>
							<td class="cart-quantity"><?php echo $count?></td>
							<td class="cart-pt" colspan="2"><?php echo $total." € TTC"?></td>
						</tr>
					</tbody>
				</table>
				<button type="submit" name="valider" value="Valider panier" class="btn-input">Payer</button> 
			</form>
			<?php $user_valid = $_SESSION["loggued_on_user"]."_valid"; if ($_SESSION[$user_valid]): ?>
				<p class="text-center" style="color:green;">Votre commande est en attente de confirmation</p>
			<?php endif; ?>
		</div>
	</div>
</body>
</html>