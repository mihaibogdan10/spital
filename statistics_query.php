<?php

	require_once 'models/PatientModel.php';
	require_once 'models/RecordModel.php';
	require_once '__Variables.php';
	require_once '__DBConnect.php';
	require_once '__TwigConfig.php';
	require_once '__PermissionStudent.php';
	
	$sex = isset($_POST['sex']) ? $_POST['sex'] : "Both";
	$age_range = isset($_POST['age_range']) ? $_POST['age_range'] : null;
	
	$sql = "SELECT * FROM (SELECT cnp, investigation, DATE_FORMAT ( FROM_DAYS ( TO_DAYS ( NOW() ) - TO_DAYS ( concat(
			(CASE 
				WHEN substr(cnp, 1, 1) in ('1', '2') THEN '19'
				WHEN substr(cnp, 1, 1) in ('3', '4') THEN '18'
				ELSE '20'
			END), substr(cnp, 2, 2), '-', substr(cnp, 4, 2), '-', substr(cnp, 6, 2)))), '%Y') + 0 as 'age'
		FROM record, patient WHERE record.patient = patient.id) AS derived_table WHERE 1";
	
	if ($sex == "Male")
		$sql .= " AND mod(substr(cnp,1,1), 2) = 1";
	else if ($sex == "Female")
		$sql .= " AND mod(substr(cnp,1,1), 2) = 0";
	
	if ($age_range){
		$exploded_age_range = explode('-', $age_range);
		try{
			$min_age = (int)$exploded_age_range[0];
			$max_age = (int)$exploded_age_range[1];
		}
		catch (Exception $e){
			//shouldn't
		}
	}
	
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
