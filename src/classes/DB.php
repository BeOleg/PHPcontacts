<?php
	class DB extends DBLink{
		public static function getContacts($userId, $queryString = ' ', $days = null){
			//Todo: ADD a condition for an empty queryString
			$sql = "SELECT first_name, last_name, bday,  YEAR(CURDATE())-YEAR(bday) as age_years FROM usesrs u1 
			WHERE user_id IN (SELECT contact_id FROM contacts WHERE user_id = :uid)
			AND (CONCAT(first_name, ' ', last_name) LIKE :queryString OR CONCAT(last_name, ' ', first_name) LIKE :queryString";
			if(isset($days) && $days){
				$sql .=  " AND DATE_ADD(bday, INTERVAL YEAR(CURDATE())-YEAR(bday) YEAR) 
            			BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL :days DAY)";//Make the bithday year and the current yer equal, and compare only the day interval
			
}			try{
				$conn = SELF::getInstance();
				$sth = $conn->prepare($sql);
				$sth->bindParam(':uid', $userId, PDO::PARAM_INT);
				$sth->bindParam(':queryString', $queryString, PDO::PARAM_STR);
				if(isset($days) && $days)
					$sth->bindParam(':days', $days, PDO::PARAM_INT);
				$sth->execute();
				return $sth->fetchAll(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e){
				Debugger::HandleException($e);
			}
			
		}
		public static function getUsers($queryString = null){
			$sql = "SELECT u.id, u.first_name, u.last_name, u.email, (SELECT COUNT(1) FROM contacts where user_id = u.id) as contact_count FROM users u";
			if($queryString){
				$sql .= ' WHERE (CONCAT(u.first_name, " ", u.last_name) LIKE :queryString OR CONCAT(u.last_name, " ", u.first_name) LIKE :queryString)';
			}
			try{
				$conn = SELF::getInstance();
				$sth = $conn->prepare($sql);
				if($queryString){
					$sth->bindValue(':queryString', "%{$queryString}%");
				}
				$sth->execute();
				return $sth->fetchAll(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e){
				Debugger::HandleException($e);
			}
		}
		public function multipleInsert($table, $data = array()){
		 	try{
		      if (count($data) > 0){
		          $fieldnames = isset($data[0]) ? array_keys($data[0]) : array_keys($data);
		          $count_inserts = count(array_values($data));
		          $count_values = isset($data[0]) ? count(array_values($data[0])) : count(array_values($data));
		          $conn = SELF::getInstance();

		          for($i = 0; $i < $count_values; $i++)
		          {
		              $placeholder[] = '?';
		          }


		          for ($i=0; $i < $count_inserts; $i++) 
		          { 
		              $placeholders[] = '('. rtrim(implode(',' ,$placeholder), ',')  . ')';
		          }

		          $query  = 'INSERT INTO '. $table;
		          $query .= '(`'. implode('`, `', $fieldnames) .'`)';
		          $query .= ' VALUES '. implode(', ', $placeholders);

		          $insert = $conn->prepare($query);

		          $i = 0;
		          foreach($data as $item) 
		          {

		                foreach ($item as $key => $value) 
		                { 
		                  $i++; 
		                   // if($i <= $count_values * $count_inserts)
		                  if(is_int($item[$key])){
		                    $insert->bindParam($i, $item[$key], PDO::PARAM_INT);
		                  }
		                  else if(empty($item[$key]) || $item[$key] == ''){
		                    $item[$key] = null;
		                    $insert->bindParam($i, $item[$key], PDO::PARAM_NULL);
		                  }
		                  else{
		                    $insert->bindParam($i, $item[$key], PDO::PARAM_STR);
		                  }
		                   
		                }  
		          }
		          $insert->execute();
		          // $past_last_inserted = $conn->lastInsertId();
		          $last_inserted = $conn->lastInsertId();
		          $return['success'] = $count_inserts;
		          for($i = 0; $i < $count_inserts ; $i++){
		            $return[$i] = $last_inserted + $i;  
		          }
		          // echo $conn->lastInsertId();
		          return $return;
		      } 
		  }
		 catch(PDOException $e){
		 	echo $query;
	   		Debugger::HandleException($e);
		  }
		}
		public function exec($sql){
			try{
				$conn = SELF::getInstance();
				$conn->exec($sql);
			}
		   catch(PDOException $e){
		 		echo $query;
	   			Debugger::HandleException($e);
		  }
		}
	}
?>