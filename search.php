<?php

	require_once 'models/PatientModel.php';
	require_once 'models/RecordModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__DBConnect.php';
	require_once 'config/__TwigConfig.php';
	require_once 'config/__PermissionDoctor.php';
	
	$query = trim(isset($_GET['q']) ? $_GET['q'] : NULL);
	$wt = 'search_' . (isset($_GET['wt']) ? $_GET['wt'] : 'patient');
	$tags = isset($_POST['tags']) ? $_POST['tags'] : '';

	$id = isset($_GET['id']) ? $_GET['id'] : NULL;
	$sortBy = isset($_GET['by']) ? $_GET['by'] : NULL;
	$sortMode = isset($_GET['mode']) ? $_GET['mode'] : 'ASC';
	$inferior = isset($_GET['inferior']) ? $_GET['inferior'] : 0;
	$ipp = isset($_GET['ipp']) ? $_GET['ipp'] : 200;

	$pg = isset($_GET['pg']) ? $_GET['pg'] : 1;


	if(count($_GET) < 3) {
		$template = $twig->loadTemplate($wt.'.html');
			echo $template->render(array(
								'user' => $_SESSION['user'],
								'query' => $query,
							)
			);
		return;
	}

	
	////////////////////////////////////////////////////////////////////////////////////////////////////////



/*	if (!isset($_SESSION[$wt])) {
		$_SESSION[$wt] = array(
			'by' => 'id', 
			'mode' => 'ASC', 
			'isLast' => false, 
			'offset' => 0, 
			'ipp' => 200, //items per page -> va fi in jur de 500
			'po' => 10 // cu cate elemente/pagina sa pagineze javascript;
		);
	}

	// cu cate elemente/pagina sa pagineze javascript
	$_SESSION[$wt]['po'] = isset($_GET['po']) ? $_GET['po'] : $_SESSION[$wt]['po'];

	$sortBy = $_SESSION[$wt]['by'];
	$sortMode = $_SESSION[$wt]['mode'];

	if (isset($_GET['inferior'])) {	
		//daca ii spun de unde sa inceapa, inseamna ca schimb pagina
		$inferior = $_GET['inferior'];
	}
	else {
		$inferior = 0;
		if (isset($_GET['by'])) {
			$by = $_GET['by'];
			if ($by === $_SESSION[$wt]['by']) {
				// am facut click pe aceeasi coloana de pe care era deja facuta sortarea
				// in concluzie, schimb sensul sortarii
				$_SESSION[$wt]['mode'] = ($_SESSION[$wt]['mode'] === 'ASC') ? 'DESC' : 'ASC';
			}
			else {
				// sortez dupa o alta coloana
				$_SESSION[$wt]['by'] = $by;
				$_SESSION[$wt]['mode'] = 'ASC';
			}
		}
	}*/
	

	if ($wt != "search_record") {

		$records = array();
		$patients = Patient::search2(array(
			'q' => $query,
			'fields' => array('firstname__contains', 'lastname__contains', 'cnp__contains'),
			'inferior' => $inferior, 
			'offset' => $ipp,
			'sortBy' => $sortBy,
			'sortMode' => $sortMode)
		);

		$entries = Patient::search_number(array(
			'q' => $query,
			'fields' => array('firstname__contains', 'lastname__contains', 'cnp__contains'))
		);

/*		$n = count(Patient::search2(array(
			'q' => $query,
			'fields' => array('firstname__contains', 'lastname__contains', 'cnp__contains'),
			'inferior' => $inferior + $ipp, 
			'offset' => 1
		)));
		//ma uit daca mai e vreo intrare dupa aceste intrari
*/
		$template_name = "patients_table.html";
	}

	else {

		$patients = array();
		$records = Record::search2(array(
			'q' => $query,
			'fields' => array('investigation__contains', 'investigation_result__contains', 'sending_medic__contains', 'sending_diagnosis__contains'),
			'inferior' => $inferior, 
			'offset' => $ipp,
			'sortBy' => $sortBy,
			'sortMode' => $sortMode)
		);

		$entries = Record::search_number(array(
			'q' => $query,
			'fields' => array('investigation__contains', 'investigation_result__contains', 'sending_medic__contains', 'sending_diagnosis__contains'))
		);

/*		$n = count(Record::search2(array(
			'q' => $query,
			'fields' => array('investigation__contains', 'investigation_result__contains', 'sending_medic__contains', 'sending_diagnosis__contains'),
			'inferior' => $inferior + $ipp, 
			'offset' => 1
		)));*/

		$template_name = "records_search_table.html";
	}


//	$_SESSION[$wt]['offset'] = $inferior;

	
	
	$template = $twig->loadTemplate($template_name);
	echo $template->render(array(
		'user' => $_SESSION['user'], 
		'patients' => $patients, 
		'records' => $records, 
		'query' => $query,
		'entries' => $entries)
	);

?>