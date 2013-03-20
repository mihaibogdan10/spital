<?php
	require_once "paths.php";
	require_once $ROOT."/models/UserModel.php";
	require_once $ROOT."/models/PatientModel.php";
	require_once $ROOT."/models/RecordModel.php";
	require_once $ROOT."/config/__Variables.php";
	require_once $ROOT."/config/__DBConnect.php";
	require_once $ROOT."/config/__PermissionDoctor.php";
	
	$columns = array('id', 'category', 'sending_medic', 'sending_diagnosis', 'investigation', 'investigation_result', 
				'radiopharmaceutical_isotope', 'dose', 'gamma_room', 'collimator', 'clinic', 'tags');
	
	$passed_data = array();
	foreach ($columns as $key => $column)
		$passed_data[$column] = isset($_POST[$column]) ? $_POST[$column] : NULL;
		
	if ($passed_data['id'] == NULL) {
		header("location: /spital/patient.php");
		exit(0);
	}
	
	$user = $_SESSION['user'];
	$record = new Record($passed_data);
	
	try{
		$old_record = Record::get(array('id' => $record ->id));
		$patient = $old_record -> getPatient();
		$patient -> updated = date('Y.m.d H:i:s');
	}
	catch (Exception $e){
		// eroare
		header("location: /spital/patient.php?id={$patient -> id}#Nu exista un pacient pentru fisa aceasta");
		exit(0);
	}
	
	if ($record->save() && $patient->save()) { // success
		//redirect to the patient's page with ok message
		header("location: /spital/patient.php?id={$patient -> id}#Fisa a fost salvata.");
		exit(0);
	}
	else { // eroare
		header("location: spital/patient.php?id={$patient -> id }#Error");
		exit(0);
	}
	
?>