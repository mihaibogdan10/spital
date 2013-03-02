<?php

	require_once 'models/UserModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__TwigConfig.php';
	
	$template = $twig->loadTemplate('about.html');
	echo $template->render(array('user' => $_SESSION['user']));

?>