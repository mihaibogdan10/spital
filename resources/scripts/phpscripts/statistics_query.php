<?php

	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/models/PatientModel.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/models/RecordModel.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/config/__Variables.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/config/__DBConnect.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/config/__TwigConfig.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/spital/config/__PermissionStudent.php';
	
	$sex = isset($_POST['sex']) ? $_POST['sex'] : "B &amp; F";
	$min_age = isset($_POST['min_age']) ? $_POST['min_age'] : null;
	$max_age = isset($_POST['max_age']) ? $_POST['max_age'] : null;
	
	$sql = "SELECT * FROM (SELECT cnp, investigation, DATE_FORMAT ( FROM_DAYS ( TO_DAYS ( NOW() ) - TO_DAYS ( concat(
			(CASE 
				WHEN substr(cnp, 1, 1) in ('1', '2') THEN '19'
				WHEN substr(cnp, 1, 1) in ('3', '4') THEN '18'
				ELSE '20'
			END), substr(cnp, 2, 2), '-', substr(cnp, 4, 2), '-', substr(cnp, 6, 2)))), '%Y') + 0 as 'age'
		FROM record, patient WHERE record.patient = patient.id) AS derived_table WHERE 1";
	
	if ($sex == "B")
		$sql .= " AND mod(substr(cnp,1,1), 2) = 1";
	else if ($sex == "F")
		$sql .= " AND mod(substr(cnp,1,1), 2) = 0";
	
	if (isset($min_age) && isset($max_age))
		$sql .= sprintf(" AND age >= %d AND age <= %d", $min_age, $max_age);

	$result = mysql_query($sql) or die(mysql_error());

	$passed_data = array('scintigrama_osoasa' => 0, 'scintigrama_tiroidiana' => 0, 'scintigrama_paratiroidiana' => 0, 'scintigrama_hepatica' => 0, 'scintigrama_renala' => 0, 'scintigrama_pulmonara' => 0, 'scintigrama_de_cord' => 0, 'diverse' => 0);
		
	while ($record = mysql_fetch_assoc($result)){
		$investigation = str_replace(' ', '_', $record['investigation']); 
		if (array_key_exists($investigation, $passed_data))
			$passed_data[$investigation]++;
	}
	
	print_r (json_encode($passed_data));
?>
