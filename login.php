<?php
	require_once 'resources/scripts/phpscripts/encryption.php';
	require_once 'models/UserModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__DBConnect.php';
	
	$_POST['email'] = isset($_POST['email']) ? $_POST['email'] : NULL;
	$_POST['parola'] = isset($_POST['parola']) ? $_POST['parola'] : NULL;

	try {
		$user = User::get(
			array(
				'email' => mysql_real_escape_string($_POST['email']),
				'parola' => passEncode(mysql_real_escape_string($_POST['parola']))
			)
		);
		
		$user->Connect();
		header('location: index.php');
	}
	catch (Exception $e) {
		header("location: connect.php#Oops... Nu ai putut fi conectat");
	}

?>