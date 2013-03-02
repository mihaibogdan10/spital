<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/models/UserModel.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/models/PatientModel.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/models/RecordModel.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/config/__Variables.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/config/__DBConnect.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/config/__PermissionDoctor.php';
	
	$user = $_SESSION['user'];
	$user = ($user && $user->isStudent()) ? NULL : $user;
	$patient = Patient::get(array('id' => $_POST['patient']));
	
	$passed_data = array('patient' => $patient->id, 'addedby' => $user->id);
	$columns = array('sending_diagnosis', 'sending_medic', 'investigation', 'clinic');
	
	foreach ($columns as $key => $column)
		$passed_data[$column] = isset($_POST[$column]) ? $_POST[$column] : NULL;
	
	$record = new Record($passed_data);
		
	if ($record->save()) { // success
		header("location: ".$_SERVER['DOCUMENT_ROOT']."/spital/patient.php?id={$patient->id}");
	}
	else { // eroare
		header("location: ".$_SERVER['DOCUMENT_ROOT']."/spital/patient.php?id={$patient->id}#Eroare");
	}

?>