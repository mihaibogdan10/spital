<?php
	require_once 'models/UserModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__TwigConfig.php';
	
	switch ($_SESSION['user']) {
		// daca utilizatorul nu este logat il timit pe pagina de logare/inregistrare
		case NULL: 
			$template = $twig->loadTemplate('connect.html');
			echo $template->render(array());
		break;
		
		// altfel, afisez prima pagina :)
		default:
			header('location: index.php');
		break;
	}

?>