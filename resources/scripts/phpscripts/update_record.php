<?php

	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/models/UserModel.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/models/PatientModel.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/models/RecordModel.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/config/__Variables.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/config/__DBConnect.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/config/__PermissionDoctor.php';
	
	$columns = array('id', 'category', 'sending_medic', 'sending_diagnosis', 'investigation', 'investigation_result', 
				'radiopharmaceutical_isotope', 'dose', 'gamma_room', 'collimator', 'clinic');
	
	$passed_data = array();
	foreach ($columns as $key => $column)
		$passed_data[$column] = isset($_POST[$column]) ? $_POST[$column] : NULL;
	
	$user = $_SESSION['user'];
	$record = new Record($passed_data);
			
	if ($record->save()) { // success
		header("location: edit_record.php?id={$id}");
	}
	else { // eroare
		header("location: edit_record.php?id={$id}#msg=Error");
	}
	
?>