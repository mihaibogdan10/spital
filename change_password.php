<?php
	require_once 'encryption.php';
	require_once 'models/UserModel.php';
	require_once '__Variables.php';
	require_once '__DBConnect.php';
	
	$_POST['nume'] = isset($_POST['nume']) ? $_POST['nume'] : NULL;
	$_POST['prenume'] = isset($_POST['prenume']) ? $_POST['prenume'] : NULL;
	$_POST['parola'] = isset($_POST['parola']) ? $_POST['parola'] : NULL;
	$_POST['parola1'] = isset($_POST['parola1']) ? $_POST['parola1'] : NULL;
	$_POST['parola2'] = isset($_POST['parola2']) ? $_POST['parola2'] : NULL;
	$password = isset($_POST['psc']) ? true : false;
	
	$user = $_SESSION['user'];


	try {
		if ($password)
			if ($user->parola == passEncode(mysql_real_escape_string($_POST['parola'])))
				$user->parola = passEncode(mysql_real_escape_string($_POST['parola1']));
			else
				header('location: user.php#Parola veche este incorecta! Nu am schimbat datele!');
		
		$user->nume = mysql_real_escape_string($_POST['nume']);
		$user->prenume = mysql_real_escape_string($_POST['prenume']);
				
		$user->save();
		$user->Connect();
		header('location: user.php#Datele schimbate cu succes!');
	}
	catch (Exception $ex) { // parola nu e corecta	
		header('location: user.php#Nu am putut schimba datele!');
	}
	
?>