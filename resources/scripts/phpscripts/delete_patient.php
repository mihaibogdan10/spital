<?php
	require_once "paths.php";
	require_once $ROOT."/models/PatientModel.php";
	require_once $ROOT."/config/__Variables.php";
	require_once $ROOT."/config/__DBConnect.php";
	require_once $ROOT."/config/__PermissionDoctor.php";
	
	$_GET['id'] = isset($_GET['id']) ? $_GET['id'] : NULL;
	
	try { $patient = Patient::get(array('id' => $_GET['id'])); }
	catch (Exception $ex) { 
		header("location: /spital/patient.php#{$ex->getMessage()}"); 
		exit(0);
	}
	
	if ($patient->delete()) {
		header("location: /spital/patient.php#Pacientul impreuna cu toate fisele sale a fost sterse.");
		exit(0);
	}
	else {
		header("location: /spital/patient.php#Oops... Pacientul nu a fost sters");
		exit(0);
	}
?>
