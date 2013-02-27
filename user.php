<?php
	require_once 'models/UserModel.php';
	require_once '__Variables.php';
	require_once '__TwigConfig.php';
	
//	switch ($_SESSION['user']) {
		// daca utilizatorul nu este logat il timit pe pagina de logare/inregistrare
	//	case NULL: 
			$template = $twig->loadTemplate('user.html');
			echo $template->render(array('user' => $_SESSION['user']));
	//	break;
		
		// altfel, afisez prima pagina :)
	//	default:
	//		header('location: index.php');
	//	break;
//	}

?>