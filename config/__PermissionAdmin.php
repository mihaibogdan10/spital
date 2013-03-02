<?php

	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/models/UserModel.php';
	require_once '__Variables.php';
	
	$user=  $_SESSION['user'];
	if ($user == NULL || $user->isStudent() || $user->isDoctor())
		header('location: connect.php#Nu ai acces pe acesta pagina!');

?>