<?php
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/resources/scripts/phpscripts/encryption.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/models/UserModel.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__Variables.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__DBConnect.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__PermissionStudent.php"; // trebuie sa fii logat
	
	$_POST['nume'] = isset($_POST['nume']) ? $_POST['nume'] : NULL;
	$_POST['prenume'] = isset($_POST['prenume']) ? $_POST['prenume'] : NULL;
	$_POST['password'] = isset($_POST['password']) ? $_POST['password'] : NULL;
	$_POST['parola1'] = isset($_POST['parola1']) ? $_POST['parola1'] : NULL;
	$_POST['parola2'] = isset($_POST['parola2']) ? $_POST['parola2'] : NULL;
	$password = isset($_POST['psc']) ? true : false;
	
	$user = $_SESSION['user'];

	try {
		if (!($user->parola == passEncode(mysql_real_escape_string($_POST['password'])))) {
			header('location: /spital/user.php#Parola este incorecta! Nu am schimbat datele!');
			exit(0);
		}
		else {
			if ($password)
				$user->parola = passEncode(mysql_real_escape_string($_POST['parola1']));

			$user->nume = mysql_real_escape_string($_POST['nume']);
			$user->prenume = mysql_real_escape_string($_POST['prenume']);
					
			$user->save();
			$user->Connect();
			header('location: /spital/user.php#Datele schimbate cu succes!');
			exit(0);
		}
	}
	catch (Exception $ex) { // parola nu e corecta	
		header('location: /spital/user.php#Nu am putut schimba datele!');
		exit(0);
	}
	
?>