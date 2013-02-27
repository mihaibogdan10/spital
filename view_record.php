<?php

	require_once 'models/PatientModel.php';
	require_once 'models/RecordModel.php';
	require_once '__Variables.php';
	require_once '__DBConnect.php';
	require_once '__TwigConfig.php';
	require_once '__PermissionDoctor.php';
	
	$_GET['id'] = isset($_GET['id']) ? $_GET['id'] : NULL;
	$record = Record::get(array('id' => $_GET['id']));
	
	$template = $twig->loadTemplate('view_record.html');
	echo $template->render(array('record' => $record));
?>
