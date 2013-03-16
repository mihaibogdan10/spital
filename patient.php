<?php
	require_once 'models/PatientModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__DBConnect.php';
	require_once 'config/__TwigConfig.php';
	require_once 'config/__PermissionDoctor.php';
	
	$_GET['id'] = isset($_GET['id']) ? $_GET['id'] : NULL;
	$pg = isset($_GET['pg']) ? $_GET['pg'] : 1;

	// cu cate elemente/pagina sa pagineze javascript
	$pgOpt = isset($_GET['po']) ? $_GET['po'] : 10; // 5 pt teste, probabil va fi 10

	if (!isset($_SESSION['sort'])) {
		$_SESSION['sort'] = array(
			'by' => 'id', 
			'mode' => 'ASC', 
			'isLast' => false, 
			'offset' => 0, 
			'ipp' => 100 //items per page, 10 pentru teste, va fi in jur de 500
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
	}
	
	switch ($_GET['id']) {
		case !NULL:
			try { $patient = Patient::get(array('id' => $_GET['id'])); }
			catch (Exception $ex) { header("location: patient.php"); exit(0); }
			$template = $twig->loadTemplate('patient_details.html');
			echo $template->render(array('user' => $_SESSION['user'], 'patient' => $patient));
		break;
		
		default:
	
//			$patients = Patient::all();
			$patients = Patient::range( array(
				'inferior' => $inferior, 
				'offset' => $_SESSION['sort']['ipp'],
				'sortBy' => $_SESSION['sort']['by'],
				'sortMode' => $_SESSION['sort']['mode'])
			);

			$n = count(Patient::range( array(
							'inferior' => $inferior + 10, 
							'offset' => 1)
						)
			//ma uit daca mai e vreo intrare dupa aceste intrari
			);
			
			if ($n == 0) {
				$_SESSION['sort']['isLast'] = 1;
			}
			else {
				$_SESSION['sort']['isLast'] = 0;
			}

			$_SESSION['sort']['offset'] = $inferior;
	
			$template = $twig->loadTemplate('patient.html');
			echo $template->render(array(
								'user' => $_SESSION['user'], 
								'patients' => $patients, 
								'sort' => $_SESSION['sort'], 
								'pg' => $pg,
								'pgOpt' => $pgOpt
							)
			);
		break;
	}

?>