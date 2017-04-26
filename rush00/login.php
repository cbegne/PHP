<?php
    session_start() or die("Failed to resume session\n");

	require 'auth.php';
	require 'connect.php';

	$conn = connect();

	$basket = $_SESSION['basket'];

	$login = mysqli_real_escape_string($conn, trim($_POST['login']));
	$passwd = mysqli_real_escape_string($conn, trim($_POST['passwd']));
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
			<h2 class="text-center">Connexion</h2><br>
			<?php if ($_POST['submit'] === "OK" and !auth($conn, $login, $passwd)): ?>
				<p class="text-center" style="color:red;">Identifiants incorrect</p>
			<?php endif; ?>
			<form method="post" class="form">
				Identifiant<br><input type="text" name="login" value=""><br>
				Mot de passe<br><input type="password" name="passwd" value=""><br>
				<input type="submit" name="submit" value="OK" class="btn-input">
			</form>
			<br><a href="create.php" class="text-center">Créer un compte</a>
			<br><a href="modif.php" class="text-center">Modifier votre mot de passe</a>
		</div>
	</div>
</body>
</html>

<?php


	if ($_POST['login'] == '' or $_POST['passwd'] == '' or $_POST['submit'] !== "OK")
		return ;
//	$login = mysqli_real_escape_string($conn, trim($_POST['login']));
//	$passwd = mysqli_real_escape_string($conn, trim($_POST['passwd']));
	if ($_SESSION["loggued_on_user"] === 'Guest')
		$_SESSION["Guest_basket"] = $_SESSION["basket"];
	$_SESSION["loggued_on_user"] = (auth($conn, $login, $passwd)) ? $login : 'Guest';
	$_SESSION["admin"] = is_admin($conn, $login);

	if (auth($conn, $login, $passwd))
	{
		$saved_basket = $_SESSION["loggued_on_user"]."_basket";
		$_SESSION["basket"] = $_SESSION[$saved_basket];
		if ($_SESSION['need_auth'])
		{
			$_SESSION["basket"] = $_SESSION["Guest_basket"];
			echo '<meta http-equiv="refresh" content="0;url=panier.php">';
		}
		else
			echo '<meta http-equiv="refresh" content="0;url=home.php">';
	}
	else
		return ;//echo "ERROR";

?>