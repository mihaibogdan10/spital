<?php
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/resources/scripts/phpscripts/encryption.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/models/UserModel.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__Variables.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__DBConnect.php";
	
	$_POST['id'] = isset($_POST['id']) ? $_POST['id'] : NULL;
	$_POST['parola1'] = isset($_POST['parola1']) ? $_POST['parola1'] : NULL;
	$_POST['parola2'] = isset($_POST['parola2']) ? $_POST['parola2'] : NULL;
	

	try {
		$user = User::get(
			array(
				'id' => intval($_POST['id'])
			)
		);
		
		$user->parola = passEncode(mysql_real_escape_string($_POST['parola1']));
					
		$user->save();
		$user->Connect();
		header('location: /spital/index.php#Parola schimbata cu succes!');
		exit(0);

	}
	catch (Exception $ex) { // parola nu e corecta	
		header('location: /spital/index.php#Nu am putut schimba datele! '.$_POST['id']);
		exit(0);
	}
	
?>