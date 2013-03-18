<?php

	require_once 'models/PatientModel.php';
	require_once 'models/RecordModel.php';
	require_once 'config/__Variables.php';
	require_once 'config/__DBConnect.php';
	require_once 'config/__TwigConfig.php';
	require_once 'config/__PermissionDoctor.php';
	
	$_GET['q'] = trim(isset($_GET['q']) ? $_GET['q'] : NULL);
	$wt = 'sort_' . (isset($_GET['wt']) ? $_GET['wt'] : 'patient');



	////////////////////////////////////////////////////////////////////////////////////////////////////////

	$_GET['id'] = isset($_GET['id']) ? $_GET['id'] : NULL;
	$pg = isset($_GET['pg']) ? $_GET['pg'] : 1;


	if (!isset($_SESSION[$wt])) {
		$_SESSION[$wt] = array(
			'by' => 'id', 
			'mode' => 'ASC', 
			'isLast' => false, 
			'offset' => 0, 
			'ipp' => 200, //items per page, 10 pentru teste, va fi in jur de 500,
			'po' => 10 // cu cate elemente/pagina sa pagineze javascript; 5 pt teste, probabil va fi 10
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
	}
	

	if ($wt != "sort_record") {

		$records = array();
		$patients = Patient::search2(array(
			'q' => $_GET['q'],
			'fields' => array('firstname__contains', 'lastname__contains', 'cnp__contains'),
			'inferior' => $inferior, 
			'offset' => $_SESSION[$wt]['ipp'],
			'sortBy' => $_SESSION[$wt]['by'],
			'sortMode' => $_SESSION[$wt]['mode'])
		);

		$n = count(Patient::search2(array(
			'q' => $_GET['q'],
			'fields' => array('firstname__contains', 'lastname__contains', 'cnp__contains'),
			'inferior' => $inferior + $_SESSION[$wt]['ipp'], 
			'offset' => 1
		)));
		//ma uit daca mai e vreo intrare dupa aceste intrari

		$template_name = "search_patient.html";
	}

	else {

		$patients = array();
		$records = Record::search2(array(
			'q' => $_GET['q'],
			'fields' => array('investigation__contains', 'investigation_result__contains', 'sending_medic__contains', 'sending_diagnosis__contains'),
			'inferior' => $inferior, 
			'offset' => $_SESSION[$wt]['ipp'],
			'sortBy' => $_SESSION[$wt]['by'],
			'sortMode' => $_SESSION[$wt]['mode'])
		);

		$n = count(Record::search2(array(
			'q' => $_GET['q'],
			'fields' => array('investigation__contains', 'investigation_result__contains', 'sending_medic__contains', 'sending_diagnosis__contains'),
			'inferior' => $inferior + $_SESSION[$wt]['ipp'], 
			'offset' => 1
		)));

		$template_name = "search_record.html";
	}


	if ($n == 0) {
		$_SESSION[$wt]['isLast'] = 1;
	}
	else {
		$_SESSION[$wt]['isLast'] = 0;
	}
	$_SESSION[$wt]['offset'] = $inferior;

	
	
	$template = $twig->loadTemplate($template_name);
	echo $template->render(array(
		'user' => $_SESSION['user'], 
		'patients' => $patients, 
		'records' => $records, 
		'sort' => $_SESSION[$wt],
		'query' => $_GET['q'],
		'pg' => $pg)
	);

?>