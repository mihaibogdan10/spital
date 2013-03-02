<?php
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/models/UserModel.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/models/PatientModel.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/models/RecordModel.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__Variables.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__DBConnect.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__PermissionDoctor.php";
	
	$user = $_SESSION['user'];
	$columns = array('patient', 'sending_diagnosis', 'sending_medic', 'investigation', 'clinic');
	foreach ($columns as $column) {
		$_POST[$column] = isset($_POST[$column]) ? $_POST[$column] : NULL;
		$passed_data[$column] = $_POST[$column];
	}
	
	try { $patient = Patient::get(array('id' => $_POST['patient'])); }
	catch (Exception $ex) { header("location: /spital/patient.php"); exit(0); }
	$passed_data['patient'] = $patient->id;
	$passed_data['addedby'] = $user->id;	
	$record = new Record($passed_data);
		
	if ($record->save()) { // success
		header("location: /spital/patient.php?id={$patient->id}");
		exit(0);
	}
	else { // eroare
		header("location: /spital/patient.php?id={$patient->id}#Eroare");
		exit(0);
	}

?>