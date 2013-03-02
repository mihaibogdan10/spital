<?php

	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/models/PatientModel.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/config/__Variables.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/config/__DBConnect.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/config/__PermissionDoctor.php';
	
	$_GET['id'] = isset($_GET['id']) ? $_GET['id'] : NULL;
	
	try { $patient = Patient::get(array('id' => $_GET['id'])); }
	catch (Exception $ex) { header("location: patient.php#{$ex->getMessage()}"); }
	
	if ($patient->delete())
		header("location: patient.php#Pacientul impreuna cu toate fisele sale a fost sterse.");
	else
		header("location: patient.php#Oops... Pacientul nu a fost sters");
		
		

?>