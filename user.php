<?php
	require_once 'models/UserModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__TwigConfig.php';
	require_once 'config/__PermissionStudent.php';
	
	$template = $twig->loadTemplate('user.html');
	echo $template->render(array('user' => $_SESSION['user']));

?>