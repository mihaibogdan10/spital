<?php

	require_once "models/PatientModel.php";
	require_once "models/RecordModel.php";
	require_once "config/__Variables.php";
	require_once "config/__DBConnect.php";
	require_once "config/__TwigConfig.php";
	require_once "config/__PermissionDoctor.php";
	
	$_GET['id'] = isset($_GET['id']) ? $_GET['id'] : NULL;
	try { $record = Record::get(array('id' => $_GET['id'])); }
	catch(Exception $ex) { header("location: /spital/patient.php"); exit(0); }
	
	$template = $twig->loadTemplate('edit_record.html');
	echo $template->render(array('user' => $_SESSION['user'], 'record' => $record));
?>
