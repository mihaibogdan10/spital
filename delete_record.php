<?php

	require_once 'models/RecordModel.php';
	require_once '__Variables.php';
	require_once '__DBConnect.php';
	require_once '__PermissionDoctor.php';
	
	$_GET['id'] = isset($_GET['id']) ? $_GET['id'] : NULL;
	
	try { $record = Record::get(array('id' => $_GET['id'])); }
	catch (Exception $ex) { header("location: patient.php#Oops... Fisa nu exista!"); }
	try { $patient = $record->getPatient(); }
	catch (Exception $ex) { header("location: patient.php#Fisa nu apartine unui pacient"); }

	if ($record->delete())
		header("location: patient.php?id={$patient->id}#Fisa a fost stearsa!");
	else
		header("location: patient.php?id={$patient->id}#A aparut o eroare. Fisa nu a fost stearsa!");

?>