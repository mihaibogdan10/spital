<?php
	require_once 'models/UserModel.php';
	require_once "models/RecoveryModel.php";
	require_once 'config/__Variables.php';
	require_once 'config/__TwigConfig.php';
	require_once "config/__DBConnect.php";
	
	if (isset($_SESSION['user'])) {

		session_start();
		session_unset();
		session_destroy();
	}


	if (!isset($_GET['id'])) {

		header('location: index.php#Link invalid!');
		exit(0);
	}

	$key = mysql_real_escape_string($_GET['id']);

	try {

		$recovery = Recovery::get(
			array(
				'key' => $key
			)
		);

		$email = $recovery->email;
		$registered = $recovery->expire;

		if ($registered < (time() - (60 * 60)) ) {
			$recovery->delete();
			header('location: index.php#Link expirat!');
			exit(0);
		}
		$recovery->delete();
	}
	catch (Exception $ef) {
		header('location: index.php#Link invalid!');
		exit(0);
	}


	try {
		$user = User::get(
			array(
				'email' => mysql_real_escape_string($email),
			)
		);

	}
	catch (Exception $e) {
		header('location: index.php#Userul nu mai este inregistrat pe site');
		exit(0);
	}
	 
	
	$template = $twig->loadTemplate('recover.html');
	echo $template->render(array('user' => $user));
			
	
	

?>