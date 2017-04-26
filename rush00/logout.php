<?php

	header('Location: login.php');
    session_start() or die("Failed to resume session\n");

    if ($_SESSION["loggued_on_user"])
    {
        $saved_basket = $_SESSION["loggued_on_user"]."_basket";

        $_SESSION[$saved_basket] = $_SESSION["basket"];
    }
	$_SESSION["loggued_on_user"] = "Guest";
    $_SESSION["admin"] = false;
    $_SESSION["basket"] = $_SESSION["Guest_basket"];
	$_SESSION['need_auth'] = false;
?>