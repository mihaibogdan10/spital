<?php
	require_once 'models/PatientModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__DBConnect.php';
	require_once 'config/__TwigConfig.php';
	require_once 'config/__PermissionDoctor.php';
	
	$_GET['id'] = isset($_GET['id']) ? $_GET['id'] : NULL;
	
	switch ($_GET['id']) {
		case !NULL:
			try { $patient = Patient::get(array('id' => $_GET['id'])); }
			catch (Exception $ex) { header("location: patient.php"); exit(0); }
			$template = $twig->loadTemplate('patient_details.html');
			echo $template->render(array('user' => $_SESSION['user'], 'patient' => $patient));
		break;
		
		default:
	
			$patients = Patient::all();
	
			$template = $twig->loadTemplate('patient.html');
			echo $template->render(array('user' => $_SESSION['user'], 'patients' => $patients));
		break;
	}

?>