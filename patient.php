<?php
	require_once 'models/PatientModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__DBConnect.php';
	require_once 'config/__TwigConfig.php';
	require_once 'config/__PermissionDoctor.php';
	
	$id = isset($_GET['id']) ? $_GET['id'] : NULL;
	$sortBy = isset($_GET['by']) ? $_GET['by'] : NULL;
	$sortMode = isset($_GET['mode']) ? $_GET['mode'] : 'ASC';
	$inferior = isset($_GET['inferior']) ? $_GET['inferior'] : 0;
	$ipp = isset($_GET['ipp']) ? $_GET['ipp'] : 200;

	if(count($_GET) < 1) {
		$template = $twig->loadTemplate('patient.html');
			echo $template->render(array(
								'user' => $_SESSION['user']
							)
			);
		return;
	}


/*	if (!isset($_SESSION['sort'])) {
		$_SESSION['sort'] = array(
			'by' => 'id', 
			'mode' => 'ASC',
			'offset' => 0, 
			'ipp' => 200, //items per page, 10 pentru teste, va fi in jur de 500,
			'po' => 10 // cu cate elemente/pagina sa pagineze javascript; 5 pt teste, probabil va fi 10
		);
	}


	$sortBy = $_SESSION['sort']['by'];
	$sortMode = $_SESSION['sort']['mode'];

	if (isset($_GET['inferior'])) {	
		//daca ii spun de unde sa inceapa, inseamna ca schimb pagina
		$inferior = $_GET['inferior'];
	}
	else {
		$inferior = 0;
		if (isset($_GET['by'])) {
			$by = $_GET['by'];
			if ($by === $_SESSION['sort']['by']) {
				// am facut click pe aceeasi coloana de pe care era deja facuta sortarea
				// in concluzie, schimb sensul sortarii
				$_SESSION['sort']['mode'] = ($_SESSION['sort']['mode'] === 'ASC') ? 'DESC' : 'ASC';
			}
			else {
				// sortez dupa o alta coloana
				$_SESSION['sort']['by'] = $by;
				$_SESSION['sort']['mode'] = 'ASC';
			}
		}
	}*/
	
	switch ($id) {
		case !NULL:
			try { $patient = Patient::get(array('id' => $id)); }
			catch (Exception $ex) { header("location: patient.php"); exit(0); }
			$template = $twig->loadTemplate('patient_details.html');
			echo $template->render(array('user' => $_SESSION['user'], 'patient' => $patient));
		break;
		
		default:
	
			$entries = Patient::number();
			$patients = Patient::range( array(
				'inferior' => $inferior, 
				'offset' => $ipp,
				'sortBy' => $sortBy,
				'sortMode' => $sortMode)
			);


//			$_SESSION['sort']['offset'] = $inferior;
	
			$template = $twig->loadTemplate('patients_table.html');
			echo $template->render(array(
								'patients' => $patients,  
								'entries' => $entries
							)
			);
		break;
	}

?>