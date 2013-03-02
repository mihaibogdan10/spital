<?php

	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/models/UserModel.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/models/PatientModel.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/models/RecordModel.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__Variables.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__DBConnect.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__PermissionDoctor.php";
	
	$columns = array('id', 'category', 'sending_medic', 'sending_diagnosis', 'investigation', 'investigation_result', 
				'radiopharmaceutical_isotope', 'dose', 'gamma_room', 'collimator', 'clinic');
	
	$passed_data = array();
	foreach ($columns as $key => $column)
		$passed_data[$column] = isset($_POST[$column]) ? $_POST[$column] : NULL;
		
	if ($passed_data['id'] == NULL) {
		header("location: /spital/patient.php");
		exit(0);
	}
	
	$user = $_SESSION['user'];
	$record = new Record($passed_data);
	
	if ($record->save()) { // success
		header("location: /spital/edit_record.php?id={$passed_data['id']}");
		exit(0);
	}
	else { // eroare
		header("location: /spital/edit_record.php?id={$passed_data['id']}#msg=Error");
		exit(0);
	}
	
?>