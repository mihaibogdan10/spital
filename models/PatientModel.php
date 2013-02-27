<?php

	require_once 'BaseModel.php';
	require_once 'RecordModel.php';
	require_once 'UserModel.php';
	
	class Patient extends Base {
		public $id, $firstname, $lastname, $cnp, $updated;
		public $addedby;
		
		public function __construct($arr) {
			foreach($arr as $key => $value)
				$this->$key = $value;
		}
		
		function getRecords() { return Record::filter(array('patient' => $this->id)); }
		function getParent() { return User::get(array('id' => $this->addedby)); }
		function getGender() { return $this->cnp[0] % 2 == 1 ? 'Masculin' : 'Feminin'; }
		function getBirthDate() { 
			// 2 92 08 20 374511
			
			$year = $this->cnp[1].$this->cnp[2];
			if ($this->cnp[0] <= 2) $year = '19'.$year;
			else if ($this->cnp[0] <= 4) $year = '18'.$year;
			else if ($this->cnp[0] <= 6) $year += '20'.$year;
			
			$month = $this->cnp[3].$this->cnp[4];
			$day = $this->cnp[5].$this->cnp[6];
			return $day.'/'.$month.'/'.$year; 
		}
		function __toString() { return $this->lastname.' '.$this->firstname; }
	}

?>
