<?php

	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/models/UserModel.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__Variables.php";
	
	$user =  $_SESSION['user'];
	if ($user == NULL || $user->isStudent())
		header('location: /spital/connect.php#Nu ai acces pe acesta pagina!');

?>