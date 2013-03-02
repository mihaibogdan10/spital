<?php

	require_once 'models/UserModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__TwigConfig.php';
	
	$_POST['name'] = isset($_POST['name']) ? $_POST['name'] : NULL;
	$_POST['email'] = isset($_POST['email']) ? $_POST['email'] : NULL;
	$_POST['subject'] = isset($_POST['subject']) ? $_POST['subject'] : NULL;
	$_POST['message'] = isset($_POST['message']) ? $_POST['message'] : NULL;
	
	if ($_POST['email'] != NULL) {
		$to = "the_snyper06@yahoo.com, m.bogdan92@yahoo.com";
		$headers = sprintf("From: %s <%s>\r\nReply-To: %s", $_POST['name'], $_POST['email'], "contact@spital.ro");
		//mail($to, $_POST['subject'], $_POST['message'], $headers);
		//header('location: contact.php#Mesajul a fost trimis! Te vom contacta cat mai curand!');
	}
	
	$template = $twig->loadTemplate('contact.html');
	echo $template->render(array('user' => $_SESSION['user']));
?>
