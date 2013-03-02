<?php
	//////////////////////////////////////////////////////////////////////////////////////////////////////////
	// !!!Important: Am belit ochii pana la 6:50 pentu eroarea asta! tine minte data viitoare				//
	//																										//
	// Daca primesc vreo eroare de tipul _PHP_Class_Incomplete_ inseamna ca acea clasa a fost inclusa dupa	//
	// session_start(). Pentru remediere include clasa inainte de session_start()							//
	//																										//
	// http://www.youtube.com/watch?v=rs7qUJEY3Ag&noredirect=1												//
	//////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	require_once 'models/UserModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__TwigConfig.php';
	
	$template = $twig->loadTemplate('index.html');
	echo $template->render(array('user' => $_SESSION['user']));

?>