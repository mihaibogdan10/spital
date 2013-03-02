<?php

	require_once 'models/UserModel.php';
	require_once 'models/PatientModel.php';
	require_once 'models/RecordModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__DBConnect.php';
	require_once 'config/__PermissionDoctor.php';
	
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