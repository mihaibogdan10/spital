<?php

	require_once 'models/PatientModel.php';
	require_once 'models/RecordModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__DBConnect.php';
	require_once 'config/__TwigConfig.php';
	require_once 'config/__PermissionDoctor.php';
	
	$_GET['q'] = trim(isset($_GET['q']) ? $_GET['q'] : NULL);
	

	$patients = Patient::search(array(
		'q' => $_GET['q'],
		'fields' => array('firstname__contains', 'lastname__contains', 'cnp__contains')
	));
	
	$records = Record::search(array(
		'q' => $_GET['q'],
		'fields' => array('investigation__contains', 'investigation_result__contains', 'sending_medic__contains', 'sending_diagnosis__contains')
	));
	
	$template = $twig->loadTemplate('search.html');
	echo $template->render(array(
		'user' => $_SESSION['user'], 
		'patients' => $patients, 
		'records' => $records, 
		'query' => $_GET['q'])
	);

?>