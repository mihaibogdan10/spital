<?php

	require_once 'models/PatientModel.php';
	require_once 'models/RecordModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__DBConnect.php';
	require_once 'config/__TwigConfig.php';
	require_once 'config/__PermissionStudent.php';
	
	$questions = array(
		0 => "Tipuri de investigatii: viziualizati o reprezentare grafica a impartirii pe categorii de investigatii a fiselor inscrise.",
	);
	
	$template = $twig->loadTemplate('statistics.html');
	echo $template->render(array('user' => $_SESSION['user'], 'questions' => $questions));
?>
