<?php

	require_once 'models/UserModel.php';
	require_once '__Variables.php';
	
	$user =  $_SESSION['user'];
	if ($user == NULL || $user->isStudent())
		header('location: connect.php#Nu ai acces pe acesta pagina!');

?>