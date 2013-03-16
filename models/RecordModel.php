<?php

	require_once 'BaseModel.php';
	require_once 'PatientModel.php';
	require_once 'UserModel.php';
	
	class Record extends Base {
		public $id, $patient, $category, $timestamp, $sending_medic, $sending_diagnosis, $investigation, $investigation_result;
		public $gamma_room, $collimator, $radiopharmaceutical_isotope, $dose, $addedby, $clinic;
		
		public function __construct($arr) {
			foreach($arr as $key => $value)
				$this->$key = $value;
		}
		
		function getAttachments(){
			$dir = "{$_SERVER['DOCUMENT_ROOT']}/spital/resources/uploads/" . $this -> id;
			$attachments = array();
			
			//check to see if the corresponding directory exists
			if (file_exists($dir)){
				if ($handle = opendir($dir)){
					//From php manual : This is the correct way to loop over the directory.
					while (false !== ($entry = readdir($handle))) 
						if ($entry != '.' && $entry != '..')
							array_push($attachments, $entry);
				}
			}
			
			return $attachments;
		}
		function getPatient() { return Patient::get(array('id' => $this->patient)); }
		function getParent() { return User::get(array('id' => $this->addedby)); }
		function getDate() { return date_format(new DateTime($this->timestamp), 'd.m.Y');}
		function __toString() { return "Record #{$this->id}"; }
	}

?>
