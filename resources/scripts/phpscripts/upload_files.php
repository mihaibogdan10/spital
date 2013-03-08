<?php

	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/models/UserModel.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__Variables.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__DBConnect.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__PermissionDoctor.php";
	
	$MAX_FILE_SIZE = isset($_POST['MAX_FILE_SIZE']) ? $_POST['MAX_FILE_SIZE'] : 52500001;
	$record_id = isset($_POST['id']) ? $_POST['id'] : null;
	
	//see if there is anything to upload
	if(isset($_FILES['upload_files']) && $record_id){
		//echo '<pre>';
		//print_r($_FILES['upload_files']);
		//echo '</pre>';
		for($i = 0; $i < count($_FILES['upload_files']['name']); $i++) {
			
			//change the name of the file to something impossible to guess: md5(rand) + md5(name + salt)
			$old_name = $_FILES['upload_files']['name'][$i];
			$parts = explode(".",$old_name);
			$ext = array_pop($parts);
			$new_name = md5(rand()).md5($old_name.'salt:)').'.'.$ext;
			
			$uploaddir = "{$_SERVER['DOCUMENT_ROOT']}/spital/resources/uploads/" . $record_id;
			//create the upload directory if it doesn't exist
			if (!is_dir($uploaddir)) mkdir($uploaddir);
			$uploadfile = $uploaddir . '/' . basename($new_name);
			
			if (getimagesize($_FILES['upload_files']['tmp_name'][$i])){
				if (filesize($_FILES['upload_files']['tmp_name'][$i]) < $MAX_FILE_SIZE){
					//actually upload the file (presumed image)
					move_uploaded_file($_FILES['upload_files']['tmp_name'][$i], $uploadfile);
					echo $old_name.' a fost atasata<br/>';
				}
				else 
					echo $old_name.' e prea mare<br/>';
			}
			else
				echo $old_name.' nu e o imagine<br/>';
		}
	}

?>