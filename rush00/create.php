<?php
    session_start() or die("Failed to resume session\n");
	
	require 'connect.php';
	require 'check_db.php';

	$conn = connect();
	
	$basket = $_SESSION['basket'];
	$login = mysqli_real_escape_string($conn, trim($_POST["login"]));
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
			<h2 class="text-center">Création</h2><br>
			<?php if ($_POST["submit"] === "OK" and check_exist($conn, '`user`', '`login`', $login) == 1): ?>
				<p class="text-center" style="color:red;">Cet identifiant est déjà utilisé</p>
			<?php elseif (($_POST["login"] == '' or $_POST["passwd"] == '') and $_POST["submit"] === "OK"): ?>
				<p class="text-center" style="color:red;">Merci de renseigner tous les champs</p>
			<?php endif; ?>
			<form method="post" class="form">
				Identifiant<br><input type="text" name="login"><br>
				Mot de passe<br><input type="password" name="passwd"><br>
				<input type="submit" name="submit" value="OK" class="btn-input"><br>
        	</form>
			<br><a href="modif.php" class="text-center">Modifier votre mot de passe</a>
		</div>
	</div>
</body>
</html>

<?php

if ($_POST["login"] == '' or $_POST["login"] === "Guest" or $_POST["passwd"] == '' or $_POST["submit"] !== "OK")
	return ;
//	$login = mysqli_real_escape_string($conn, trim($_POST["login"]));
	if (check_exist($conn, '`user`', '`login`', $login) == 1)
		return ;
		//echo "login already used";
	else 
	{
		$passwd = mysqli_real_escape_string($conn, trim($_POST["passwd"]));
		$passwd_hash = hash('whirlpool', $passwd);
		$sql = "INSERT INTO `user` (`login`, `mdp`, `is_admin`) VALUES ('$login', '$passwd_hash', 0)";
		if (mysqli_query($conn, $sql))
		{
			$_SESSION["loggued_on_user"] = $login;
			$_SESSION["admin"] = false;
			echo '<meta http-equiv="refresh" content="0;url=home.php">';
			exit ;//echo "User created";
		}
		else
			return ;//echo "Error";
	}

?>
