<?php
	require_once "paths.php";
	require_once $ROOT."/models/UserModel.php";
	require_once $ROOT."/models/PatientModel.php";
	require_once $ROOT."/config/__Variables.php";
	require_once $ROOT."/config/__DBConnect.php";
	require_once $ROOT."/config/__PermissionDoctor.php";

	$_POST['firstname'] = isset($_POST['firstname']) ? $_POST['firstname'] : NULL;
	$_POST['lastname'] = isset($_POST['lastname']) ? $_POST['lastname'] : NULL;
	$_POST['cnp'] = isset($_POST['cnp']) ? $_POST['cnp'] : NULL;
	
	if ($_POST['firstname'] == NULL || $_POST['lastname'] == NULL || $_POST['cnp'] == NULL) {
		header("location: /spital/patient.php");
	}
	
	$user = $_SESSION['user'];
	
	$patient = new Patient(array(
		'firstname' => $_POST['firstname'],
		'lastname' => $_POST['lastname'],
		'cnp' => $_POST['cnp'],
		'addedby' => $user->id
	));
			
	if ($patient->save()) { // inregistrare reusita
		$id = Patient::get(array('cnp' => $_POST['cnp']))->id;
		header("location: /spital/patient.php?id={$id}");
		exit(0);
	} else { // eroare
		header("location: /spital/patient.php");
		exit(0);
	}

?>
