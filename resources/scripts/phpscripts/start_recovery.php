<?php
	require_once "paths.php";
	require_once $ROOT."/resources/scripts/phpscripts/encryption.php";
	require_once $ROOT."/models/RecoveryModel.php";
	require_once $ROOT."/models/UserModel.php";
	require_once $ROOT."/config/__Variables.php";
	require_once $ROOT."/config/__DBConnect.php";
	
	$_POST['email'] = isset($_POST['email']) ? $_POST['email'] : NULL;

	function myDie() {
		header("location: /spital/connect.php#Trimitere esuata - probleme de conexiune");
		exit(0);
	}

	try {
		$user = User::get(
			array(
				'email' => mysql_real_escape_string($_POST['email']),
			)
		);


		$key = passEncode(rand());
		$expire = time();

		$create_table = "CREATE TABLE IF NOT EXISTS `recovery` (  `id` int(11) NOT NULL AUTO_INCREMENT, " . 
  						"`email` varchar(100) NOT NULL, `key` varchar(32) NOT NULL, `expire` int(11) NOT NULL, " .
						"PRIMARY KEY (`id`,`key`), KEY `email` (`email`) " .
						") ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;" ;


		mysql_query($create_table) or myDie();
		

		try {
			$recovery = Recovery::get(
				array(
					'email' => mysql_real_escape_string($_POST['email']),
				)
			);

			$recovery->expire = $expire;
			$recovery->key = $key;
		}
		catch (Exception $ef) {
			$recovery = new Recovery(
				array(
					'expire' => $expire,
					'email' => mysql_real_escape_string($_POST['email']),
					'key' => $key
				)
			);

		}
		

		$recovery->save();

		$to = $_POST['email'];
		$subject = "Password change";
		$body = "Hi,\n\nHow are you? \n\nClick on the link below to reset your password \n\n" .
				"http://localhost/spital/recover.php?id=" . $key;
//		if (mail($to, $subject, $body)) {
//			header("location: /spital/connect.php#Link trimis pe adresa de e-mail");
//		}
//		else {
//			header("location: /spital/connect.php#Trimitere esuata");
//		}

		header("location: /spital/connect.php#Link trimis pe adresa de e-mail");
	}
	catch (Exception $e) {
		header("location: /spital/connect.php#adresa de e-mail nu este inregistrata pe acest site!");
	}

?>