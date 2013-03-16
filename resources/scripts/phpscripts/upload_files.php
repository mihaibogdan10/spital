<?php

	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/models/UserModel.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__Variables.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__DBConnect.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/spital/config/__PermissionDoctor.php";
	
	$MAX_FILE_SIZE = isset($_POST['MAX_FILE_SIZE']) ? $_POST['MAX_FILE_SIZE'] : 52500001;
	$record_id = isset($_POST['id']) ? $_POST['id'] : null;
	
	function imageCreateFromFile($filename, $ext) {
		if (!file_exists($filename)) {
			throw new InvalidArgumentException('File "'.$filename.'" not found.');
		}
		switch ($ext) {
			case 'jpeg':
			case 'jpg':
				return imagecreatefromjpeg($filename);
			break;

			case 'png':
				return imagecreatefrompng($filename);
			break;

			case 'gif':
				return imagecreatefromgif($filename);
			break;

			default:
				throw new InvalidArgumentException('File "'.$filename.'" is not valid jpg, png or gif image.');
			break;
		}
	}
	
	function createThumbnail($tmp_name, $ext){
		// Target dimensions for thumbnail
		$max_width = 100;
		$max_height = 100;

		// Get current dimensions
		list($width, $height, $type, $attr) = getimagesize($tmp_name);

		// Calculate the scaling we need to do to fit the image inside our frame
		$scale = min($max_width/$width, $max_height/$height);

		// Get the new dimensions
		$new_width  = ceil($scale*$width);
		$new_height = ceil($scale*$height);
			
		// Create new empty image
		$new = imagecreatetruecolor($new_width, $new_height);

		// Resize old image into new
		$image = imageCreateFromFile($tmp_name, $ext);
		imagecopyresampled($new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		return $new;
	}
	
	//see if there is anything to upload
	if(isset($_FILES['upload_files']) && $record_id){
		//echo '<pre>';
		//print_r($_FILES['upload_files']);
		//echo '</pre>';
		for($i = 0; $i < count($_FILES['upload_files']['name']); $i++) {
			
			//change the name of the file to something impossible to guess: 'fullsized_' + md5(rand) + md5(name + salt)
			//use fullsized_ at the beginning to avoid the (slim) chance that a fullsized image will be randomly prefixed by thumbnail_..
			$old_name = $_FILES['upload_files']['name'][$i];
			$tmp_name = $_FILES['upload_files']['tmp_name'][$i];
			$ext = strtolower( pathinfo( $old_name, PATHINFO_EXTENSION ));
			$new_name = md5(rand()).md5($old_name.'salt:)').'.'.$ext;
			
			$uploaddir = "{$_SERVER['DOCUMENT_ROOT']}/spital/resources/uploads/" . $record_id;
			//create the upload directory if it doesn't exist
			if (!is_dir($uploaddir)) mkdir($uploaddir);
			$uploadfile  = $uploaddir . '/fullsized_' . basename($new_name);
			
			// Also create a thumbnail version for the image to upload.
			$uploadthumb = $uploaddir . '/thumbnail_' . basename($new_name);
			
			if (getimagesize($tmp_name)){
				if (filesize($tmp_name) < $MAX_FILE_SIZE){					
					
					$new = createThumbnail($tmp_name, $ext);
					
					//actually upload the thumbnail
					imagejpeg($new, $uploadthumb, 100); // 100 means best quality
					imagedestroy($new); //free up memory
					
					//actually upload the file (presumed image)
					move_uploaded_file($tmp_name, $uploadfile);
					
					echo sprintf('fullsized_%s si thumbnail_%s au fost atasate<br/>', $old_name, $old_name);
				}
				else 
					echo $old_name.' e prea mare<br/>';
			}
			else
				echo $old_name.' nu e o imagine<br/>';
		}
	}

?>