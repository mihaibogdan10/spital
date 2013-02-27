<?php

	require_once 'models/PatientModel.php';
	require_once 'models/RecordModel.php';
	require_once '__Variables.php';
	require_once '__DBConnect.php';
	require_once '__TwigConfig.php';
	require_once '__PermissionStudent.php';
	
	$template = $twig->loadTemplate('statistics.html');
	echo $template->render(array('user' => $_SESSION['user']));
?>
