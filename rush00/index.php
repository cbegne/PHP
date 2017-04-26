<?php
	if (key_exists('init', $_GET) or !$_SESSION['loggued_on_user'])
		require_once "install.php";
	header("Location: home.php");
?>