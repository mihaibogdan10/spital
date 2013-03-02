<?php
	require_once 'resources/scripts/phpscripts/encryption.php';
	require_once 'models/UserModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__DBConnect.php';
	
	$_POST['nume'] = isset($_POST['nume']) ? $_POST['nume'] : NULL;
	$_POST['prenume'] = isset($_POST['prenume']) ? $_POST['prenume'] : NULL;
	$_POST['email'] = isset($_POST['email']) ? $_POST['email'] : NULL;
	$_POST['parola1'] = isset($_POST['parola1']) ? $_POST['parola1'] : NULL;
	$_POST['parola2'] = isset($_POST['parola2']) ? $_POST['parola2'] : NULL;
	
	try {
		$user = User::get(array('email' => mysql_real_escape_string($_POST['email'])));
		header("location: connect.php#Adresa de e-mail este folosita de alta persoana!");
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
		header('location: index.php');
	}
	
?>