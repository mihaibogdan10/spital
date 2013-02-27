<?php
	require_once 'BaseModel.php';

	class User extends Base {
		public $id, $prenume, $nume, $email, $parola, $statut;
		private $conectat;
		
		public function __construct($arr) {
			foreach($arr as $key => $value)
				$this->$key = $value;
		}
		
		function Connect() { $this->conectat = true; $_SESSION['user'] = $this; }
		function isAuthenticated() { return $this->conectat; }		
		function isAdmin() { return ($this->statut == 'admin'); }		
		function isDoctor() { return ($this->statut == 'doctor'); }
		function isStudent() { return ($this->statut == 'student'); }
		function getEmailHash() { return md5($this->email); }
		function __toString() {	return $this->prenume.' '.$this->nume; }
	}

?>