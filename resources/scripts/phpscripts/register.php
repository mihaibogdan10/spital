<?php
	require_once "paths.php";
	require_once $ROOT."/resources/scripts/phpscripts/encryption.php";
	require_once $ROOT."/models/UserModel.php";
	require_once $ROOT."/config/__Variables.php";
	require_once $ROOT."/config/__DBConnect.php";
	
	$_POST['nume'] = isset($_POST['nume']) ? $_POST['nume'] : NULL;
	$_POST['prenume'] = isset($_POST['prenume']) ? $_POST['prenume'] : NULL;
	$_POST['email'] = isset($_POST['email']) ? $_POST['email'] : NULL;
	$_POST['parola1'] = isset($_POST['parola1']) ? $_POST['parola1'] : NULL;
	$_POST['parola2'] = isset($_POST['parola2']) ? $_POST['parola2'] : NULL;
	
	if ($_POST['nume'] == NULL || $_POST['prenume'] == NULL || $_POST['email'] == NULL || $_POST['parola1'] == NULL ||
		$_POST['parola1'] != $_POST['parola2']) {
			header("location: /spital/connect.php#Date incorecte!");
			exit(0);
	}
	
	try {
		$user = User::get(array('email' => mysql_real_escape_string($_POST['email'])));
		header("location: /spital/connect.php#Adresa de e-mail este folosita de alta persoana!");
		exit(0);
	}
	catch (Exception $ex) { // email address it's not used		
		$user = new User(
			array(
				'nume' => mysql_real_escape_string($_POST['nume']),
				'prenume' => mysql_real_escape_string($_POST['prenume']),
				'email' => mysql_real_escape_string($_POST['email']),
				'parola' => passEncode(mysql_real_escape_string($_POST['parola1'])),
				'statut' => 'student'
			)
		);
			
		$user->save();
		$user->Connect();
		header('location: /spital/index.php');
		exit(0);
	}
	
?>