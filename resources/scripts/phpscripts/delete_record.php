<?php
	require_once "paths.php";
	require_once $ROOT."/models/RecordModel.php";
	require_once $ROOT."/config/__Variables.php";
	require_once $ROOT."/config/__DBConnect.php";
	require_once $ROOT."/config/__PermissionDoctor.php";
	
	$_GET['id'] = isset($_GET['id']) ? $_GET['id'] : NULL;
	
	try { $record = Record::get(array('id' => $_GET['id'])); }
	catch (Exception $ex) { header("location: /spital/patient.php#Oops... Fisa nu exista!"); exit(0); }
	try { $patient = $record->getPatient(); }
	catch (Exception $ex) { header("location: /spital/patient.php#Fisa nu apartine unui pacient"); exit(0); }

	if ($record->delete()) {
		header("location: /spital/patient.php?id={$patient->id}#Fisa a fost stearsa!");
		exit(0);
	}
	else {
		header("location: /spital/patient.php?id={$patient->id}#A aparut o eroare. Fisa nu a fost stearsa!");
		exit(0);
	}

?>