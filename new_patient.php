<?php

	require_once 'models/UserModel.php';
	require_once 'models/PatientModel.php';
	require_once '__Variables.php';
	require_once '__DBConnect.php';
	require_once '__PermissionDoctor.php';

	$_POST['firstname'] = isset($_POST['firstname']) ? $_POST['firstname'] : NULL;
	$_POST['lastname'] = isset($_POST['lastname']) ? $_POST['lastname'] : NULL;
	$_POST['cnp'] = isset($_POST['cnp']) ? $_POST['cnp'] : NULL;
	
	$user = $_SESSION['user'];
	
	$patient = new Patient(array(
		'firstname' => $_POST['firstname'],
		'lastname' => $_POST['lastname'],
		'cnp' => $_POST['cnp'],
		'addedby' => $user->id
	));
			
	if ($patient->save()) { // inregistrare reusita
		$id = Patient::get(array('cnp' => $_POST['cnp']))->id;
		header("location: patient.php?id={$id}");
	} else { // eroare
		header("location: patient.php");
	}

?>
