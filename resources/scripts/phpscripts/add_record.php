<?php

	require_once 'models/UserModel.php';
	require_once 'models/PatientModel.php';
	require_once 'models/RecordModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__DBConnect.php';
	require_once 'config/__PermissionDoctor.php';
	
	$user = $_SESSION['user'];
	$user = ($user && $user->isStudent()) ? NULL : $user;
	$patient = Patient::get(array('id' => $_POST['patient']));
	
	$passed_data = array('patient' => $patient->id, 'addedby' => $user->id);
	$columns = array('sending_diagnosis', 'sending_medic', 'investigation', 'clinic');
	
	foreach ($columns as $key => $column)
		$passed_data[$column] = isset($_POST[$column]) ? $_POST[$column] : NULL;
	
	$record = new Record($passed_data);
		
	if ($record->save()) { // success
		header("location: patient.php?id={$patient->id}");
	}
	else { // eroare
		header("location: patient.php?id={$patient->id}#Eroare");
	}

?>