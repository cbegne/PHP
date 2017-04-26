<?php
    session_start() or die("Failed to resume session\n");

	require 'connect.php';
	require 'check_db.php';

	$conn = connect();

	$basket = $_SESSION['basket'];

	$login = mysqli_real_escape_string($conn, trim($_POST["login"]));

	if (!(check_exist($conn, '`user`', '`login`', $login) == 0))
	{
		$passwd = mysqli_real_escape_string($conn, trim($_POST["oldpw"]));
		$passwd_hash = hash('whirlpool', $passwd);
		$array = get_data($conn, '`user`', '`mdp`', '`login`', $login);
		$passwd_hash_db = $array['mdp'];
	}

	if ($_POST['submit_suppr_user'] == 'OK')
	{
		$login = mysqli_real_escape_string($conn, trim($_SESSION['loggued_on_user']));
		$sql = "DELETE FROM `user` WHERE `login` = '$login'";
		mysqli_query($conn, $sql);
		echo '<meta http-equiv="refresh" content="0;url=logout.php">';
	}
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
			<h2 class="text-center">Modification</h2><br>
			<?php if ($_POST["submit"] === "OK" and check_exist($conn, '`user`', '`login`', $login) == 0): ?>
				<p class="text-center" style="color:red;">Identifiant incorrect</p>
			<?php elseif ($_POST["submit"] === "OK" and $passwd_hash != $passwd_hash_db): ?>
				<p class="text-center" style="color:red;">Mot de passe incorrect</p>
			<?php elseif (($_POST["login"] == '' or $_POST["oldpw"] == '' or $_POST["newpw"] == '') and $_POST["submit"] === "OK"): ?>
				<p class="text-center" style="color:red;">Merci de renseigner tous les champs</p>
			<?php endif; ?>
			<form method="post" class="form">
				Identifiant<br><input type="text" name="login"><br>
				Ancien mot de passe<br><input type="password" name="oldpw"><br>
				Nouveau mot de passe<br><input type="password" name="newpw"><br>
				<input type="submit" name="submit" value="OK" class="btn-input"><br>
			</form>
			<?php if ($_SESSION['loggued_on_user'] !== "Guest" and $_SESSION['loggued_on_user'] !== "root"): ?>
				<h2 class="text-center">Suppression</h2><br>
				<form method="post" class="form">
					<button type="submit" name="submit_suppr_user" value="OK" class="btn-input" style="background:red;">DELETE</button><br>
				</form>
			<?php endif; ?>
			<br><a href="create.php" class="text-center">Créer un compte</a>
		</div>
	</div>
</body>
</html>

<?php

	if ($_POST["login"] == '' or $_POST["oldpw"] == '' or $_POST["newpw"] == '' or $_POST["submit"] !== "OK")
		return ;
	//$login = mysqli_real_escape_string($conn, trim($_POST["login"]));
	if (check_exist($conn, '`user`', '`login`', $login) == 0)
		return ;//echo "Unknown user";
	else
	{
	//	$passwd = mysqli_real_escape_string($conn, trim($_POST["oldpw"]));
	//	$passwd_hash = hash('whirlpool', $passwd);
	//	$array = get_data($conn, '`user`', '`mdp`', '`login`', $login);
	//	$passwd_hash_db = $array['mdp'];
		if ($passwd_hash != $passwd_hash_db)
			return ;//echo "Incorrect password";
		else
		{
			$passwd_new = mysqli_real_escape_string($conn, trim($_POST["newpw"]));
			$passwd_new_hash = hash('whirlpool', $passwd_new);
			$sql = "UPDATE `user` SET `mdp` = '$passwd_new_hash' WHERE `login` = '$login'";
			if (mysqli_query($conn, $sql))
			{
				$_SESSION["loggued_on_user"] = $login;
				$_SESSION["admin"] = false;
				echo '<meta http-equiv="refresh" content="0;url=home.php">';
				exit ;//echo "Password updated";
			}
			else
				return ;//echo "Error";
	}
}

?>
