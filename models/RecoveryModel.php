<?php
	require_once 'BaseModel.php';

	class Recovery extends Base {
		public $id, $key, $expire, $email;
		private $conectat;
		
		public function __construct($arr) {
			foreach($arr as $keye => $value)
				$this->$keye = $value;
		}
		
	}

?>