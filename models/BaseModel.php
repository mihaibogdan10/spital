<?php
	
	class Base {
		////
		//	Nota: 
		//		Pentru fiecare clasa care o mosteneste pe aceasta trebuie sa existe
		//		o tabela in baza de date.!
		////
		
		// returneaza toate obiectele
		static function all() {
			$class = get_called_class(); // Numele clasei care apeleaza functia
			
			$sql = sprintf("select * from `%s`", mysql_real_escape_string(strtolower($class)));
			$q = mysql_query($sql) or die(mysql_error());
			
			$arr = array();
			while ($r = mysql_fetch_assoc($q))
				array_push($arr, new $class($r));
			
			return $arr;
		}

		// returneaza obiectele, intre anumite limite
		static function range($args) {
			$class = get_called_class(); // Numele clasei care apeleaza functia
			$sortBy = isset($args['sortBy']) ? $args['sortBy'] : 'id' ;
			$sortMode = isset($args['sortMode']) ? $args['sortMode'] : 'ASC' ;

			$sql = sprintf("select * from `%s` ORDER BY %s %s LIMIT %d, %d ", 
							mysql_real_escape_string(strtolower($class)),
							mysql_real_escape_string($sortBy),
							mysql_real_escape_string($sortMode),
							$args['inferior'], $args['offset']);
			$q = mysql_query($sql) or die(mysql_error());
			
			$arr = array();
			while ($r = mysql_fetch_assoc($q))
				array_push($arr, new $class($r));
			
			return $arr;
		}
		
		// returneaza obiectele dupa filtru
		// $args = array('id' => 1, 'prenume' => 'Alex');
		static function filter($args) {
			$class = get_called_class(); // Numele clasei care apeleaza functia
			
			$sql = sprintf("select * from `%s`", mysql_real_escape_string(strtolower($class)));
			$n = count($args);
			if ($n > 0) $sql .= " where";
			foreach($args as $key => $value) {
				$type = strstr($key, '__');
				$string_pattern = " `%s` = '%s'";
				$key_exploded = explode('__', $key); // firstname__contains => [firstname, contains]
				$key = $key_exploded[0]; // fac din firstname__contains => firstname
				switch($type) {
					case '__contains':
						$string_pattern = " `%s` like '%%%s%%'";
					break;					
					case '__startswith':
						$string_pattern = " `%s` like '%s%%'";
					break;					
					case '__endswith':
						$string_pattern = " `%s` like '%%%s'";
					break;
				}
				$sql .= sprintf($string_pattern, 
							mysql_real_escape_string($key), 
							mysql_real_escape_string($value));
				if (--$n > 0) $sql .= ' and';
			}
			
			$q = mysql_query($sql) or die(mysql_error());
			
			$arr = array();
			while($r = mysql_fetch_assoc($q))
				array_push($arr, new $class($r));
			return $arr;
		}
		
		// returneaza obiectul selectat sau o eroare daca sunt mai multe
		static function get($args) {
			$arr = self::filter($args);
			if (count($arr) > 1) throw new Exception("Valori multiple returnate!");
			if (count($arr) == 1) return $arr[0];
			throw new Exception("Nu a fost returnat nici un obiect!");
		}
		
		// returneaza true sau false in daca s-a/nu s-a facut insert/update
		function save() {
			$class = get_called_class();
			$arr_key = array();
			$arr_value = array();
			foreach ($this as $key => $value)
				if (isset($value)) {
					array_push($arr_key, $key);
					array_push($arr_value, $value);
				}

			if (!isset($this->id)) { // inserez o noua intrare in tabela
				$sql = sprintf("insert into `%s`(", mysql_real_escape_string(strtolower($class)));
				foreach ($arr_key as $key)
					$sql .= sprintf("`%s`, ", mysql_real_escape_string($key));
				$sql = trim($sql, ", ").") values (";
				foreach ($arr_value as $value)
					$sql .= sprintf("'%s', ", mysql_real_escape_string($value));
				$sql = trim($sql, ", ").")";
			}
			else { //fac update
				$sql = sprintf("update `%s` set ", mysql_real_escape_string(strtolower($class)));
				foreach ($this as $key => $value)
					if (isset($value) && $key != "id") {
						$sql .= sprintf("`%s` = '%s', ", 
									mysql_real_escape_string($key), 
									mysql_real_escape_string($value));
					}
				$sql = trim($sql, ", ");
				$sql .= sprintf(" where `id` = %d", mysql_real_escape_string($this->id));
			}

			$q = mysql_query($sql) or die(mysql_error());
			return $q;
		}
		
		function delete() {
			$class = get_called_class();
			$sql = sprintf("delete from `%s` where `id` = %d", 
						mysql_real_escape_string(strtolower($class)), 
						mysql_real_escape_string($this->id));
			$q = mysql_query($sql) or die(mysql_error());
			return $q;
		}
		
		/*
			* $args = array(
				'q' => 'Alexandru Mihai',
				'fields' => array('firstname', 'lastname');
			)
		*/
		static function search($args) {
			$q_arr = explode(' ', $args['q']);
			$response_array = array();
			foreach ($q_arr as $q) {
				foreach ($args['fields'] as $field) {
					// $field = firstname
					// $q = Alexandru
					
					$arr = self::filter(array(
						$field => $q
					));
					$response_array = array_merge($response_array, $arr);
				}
			}
			$response_array = array_unique($response_array);
			return $response_array;
		}


		static function search2($args) {
			$class = get_called_class(); // Numele clasei care apeleaza functia
			$sortBy = isset($args['sortBy']) ? $args['sortBy'] : 'id' ;
			$sortMode = isset($args['sortMode']) ? $args['sortMode'] : 'ASC' ;
			$inferior = isset($args['inferior']) ? $args['inferior'] : 0 ;
			$offset = isset($args['offset']) ? $args['offset'] : 1000 ;


			$sql = sprintf("select * from `%s`", 
							mysql_real_escape_string(strtolower($class)));

			$q_arr = explode(' ', $args['q']);

			$m = count($q_arr);
			if ($m > 0) $sql .= " where";

			$response_array = array();

			foreach ($q_arr as $value) {
				$n = count($args['fields']);
				$sql .= " (";
				foreach ($args['fields'] as $key) {
					// $field = firstname
					// $q = Alexandru

					$type = strstr($key, '__');
					$string_pattern = " `%s` = '%s'";
					$key_exploded = explode('__', $key); // firstname__contains => [firstname, contains]
					$key = $key_exploded[0]; // fac din firstname__contains => firstname
					switch($type) {
						case '__contains':
							$string_pattern = " `%s` like '%%%s%%'";
						break;					
						case '__startswith':
							$string_pattern = " `%s` like '%s%%'";
						break;					
						case '__endswith':
							$string_pattern = " `%s` like '%%%s'";
						break;
					}
					$sql .= sprintf($string_pattern, 
								mysql_real_escape_string($key), 
								mysql_real_escape_string($value));
					
					if (--$n > 0) $sql .= ' or';
				}
				$sql .= " )";
				if (--$m > 0) $sql .= ' and';
			}

			$sql .= sprintf(" ORDER BY %s %s LIMIT %d, %d ", 
							mysql_real_escape_string($sortBy),
							mysql_real_escape_string($sortMode),
							$inferior, $offset);

			$response = mysql_query($sql) or die(mysql_error());
			$response_array = array();
			while($r = mysql_fetch_assoc($response))
				array_push($response_array, new $class($r));
			return $response_array;
		}
		
	}

?>