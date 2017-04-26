<?php

require 'check_db.php';

function auth($conn, $login, $passwd) {
	if (check_exist($conn, '`user`', '`login`', $login) == 0)
		return (false);
	$passwd_hash = hash('whirlpool', $passwd);
	$array = get_data($conn, '`user`', '`mdp`', '`login`', $login);
	$passwd_hash_db = $array['mdp'];
	if ($passwd_hash != $passwd_hash_db)
		return (false);
	return (true);
}

function is_admin($conn, $login)
{
	$array = get_data($conn, '`user`', '`is_admin`', '`login`', $login);
	if ($array['is_admin'] == 0)
		return (false);
	return (true);
}

?>
