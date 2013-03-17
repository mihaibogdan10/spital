<?php

	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/models/UserModel.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__Variables.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__DBConnect.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__PermissionDoctor.php";
	
	$record_id = isset($_GET['record_id']) ? $_GET['record_id'] : null;
	$image_name = isset($_GET['image_name']) ? $_GET['image_name'] : null;

	if ($record_id != null){
		$dir = "{$_SERVER['DOCUMENT_ROOT']}/spital/resources/uploads/" . $record_id;
		$fullsized_image  = $dir . '/fullsized_' . $image_name;
		$thumbnail_image  = $dir . '/thumbnail_' . $image_name;
		
		if ($image_name != null && is_dir($dir) && file_exists($fullsized_image) && file_exists($thumbnail_image)){
			//try to delete the two files
			if (unlink($fullsized_image) && unlink($thumbnail_image)){
				header("location: /spital/edit_record.php?id=".$record_id."#Imaginea a fost stearsa.");
				exit(0);
			}
			//show message if delete wasn't successful
			else{
				header("location: /spital/edit_record.php?id=".$record_id."#Oops... imaginea nu au putut fi stearsa.");
				exit(0);
			}
		}
		else{
			header("location: /spital/edit_record.php?id=".$record_id."#Oops... a avut loc o eroare neasteptata.");
			exit(0);
		}
	}
	else{
		header("location: /spital/index.php#Oops... a avut loc o eroare neasteptata.");
		exit(0);
	}
?>