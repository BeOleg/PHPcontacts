<?php
	class DB extends DBLink{
		public static function getFullName($userId){
			$sql = "SELECT CONCAT(first_name, ' ', last_name) as fullName from users where id = :uid";
			try{
				$conn = self::getInstance();
				$sth = $conn->prepare($sql);
				$sth->bindParam(':uid', $userId, PDO::PARAM_INT);
				$sth->execute();
				$res = $sth->fetch(PDO::FETCH_ASSOC);
				return $res['fullName'];//TODO: DB entity shouldn't handle string concatination
			}
			catch(PDOException $e){
				Debugger::HandleException($e, $sql);
			}
		}
		public static function getContacts($queryString, $days = null){
			$sql = "SELECT u1.id, u1.first_name, u1.last_name, u1.email, (SELECT COUNT(1) FROM contacts WHERE user_id = u1.id) AS contact_count,
			 		YEAR(CURDATE())-YEAR(u1.bday) AS age_years, u1.bday as birthday_date,
			 		DATEDIFF(DATE_ADD(u1.bday, INTERVAL YEAR(CURDATE())-YEAR(u1.bday) YEAR), NOW()) AS days_till_bday,
					CONCAT(u2.first_name, ' ', u2.last_name) as ancestor_name	
				    FROM contacts c 
				    INNER JOIN users u1 ON c.contact_id = u1.id
					INNER JOIN users u2 ON c.user_id = u2.id";
					if($queryString){
						$sql .= ' WHERE CONCAT(u1.first_name, " ", u1.last_name) LIKE :queryString OR CONCAT(u1.last_name, " ", u1.first_name) LIKE :queryString';
					}	
					if(isset($days) && $days){
						$sql .= " GROUP BY u1.id HAVING days_till_bday <= :days AND days_till_bday > 0";//This determines a range of days and eliminates duplicates, TODO: seperate this functionality to a different, more lightweight function
						// $sql .=  " AND DATE_ADD(u1.bday, INTERVAL YEAR(CURDATE())-YEAR(u1.bday) YEAR) 
		    			//BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL :days DAY)";
		            			  //Make the bithday year and the current yer equal, and compare only the day interval
					
					}
					try{
						$conn = self::getInstance();
						$sth = $conn->prepare($sql);
						if($queryString){
							$sth->bindValue(':queryString', "%{$queryString}%");
						}
						if(isset($days) && $days){
							$sth->bindParam(':days', $days, PDO::PARAM_INT);
						}
						$sth->execute();
						return $sth->fetchAll(PDO::FETCH_ASSOC);
					}
					catch(PDOException $e){
						Debugger::HandleException($e, $sql);
					}
		}
		public static function getContactsByUser($userId, $queryString = null){
			//Todo: ADD a condition for an empty queryString
			$sql = "SELECT id, first_name, last_name, bday, email,
					(SELECT CONCAT(first_name, ' ', last_name) FROM users WHERE id = :uid ) AS ancestor_name,
					(SELECT COUNT(1) FROM contacts WHERE user_id = u1.id) as contact_count
					FROM users u1 
					WHERE u1.id IN (SELECT contact_id FROM contacts c WHERE user_id = :uid)";
			if($queryString){
				$sql .= ' AND (CONCAT(first_name, " ", last_name) LIKE :queryString OR CONCAT(last_name, " ", first_name) LIKE :queryString)';
			}			
			try{
				$conn = self::getInstance();
				$sth = $conn->prepare($sql);
				$sth->bindParam(':uid', $userId, PDO::PARAM_INT);
				if($queryString){
					$sth->bindValue(':queryString', "%{$queryString}%");
				}

				$sth->execute();
				return $sth->fetchAll(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e){
				Debugger::HandleException($e, $sql);
			}
			
		}
		public static function getUsers($queryString = null){
			$sql = "SELECT u.id, u.first_name, u.last_name, u.email, (SELECT COUNT(1) FROM contacts where user_id = u.id) as contact_count FROM users u";
			if($queryString){
				$sql .= ' WHERE (CONCAT(u.first_name, " ", u.last_name) LIKE :queryString OR CONCAT(u.last_name, " ", u.first_name) LIKE :queryString)';
			}
			try{
				$conn = self::getInstance();
				$sth = $conn->prepare($sql);
				if($queryString){
					$sth->bindValue(':queryString', "%{$queryString}%");
				}
				$sth->execute();
				return $sth->fetchAll(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e){
				Debugger::HandleException($e, $sql);
			}
		}
		public function multipleInsert($table, $data = array()){
		 	try{
		      if (count($data) > 0){
		          $fieldnames = isset($data[0]) ? array_keys($data[0]) : array_keys($data);
		          $count_inserts = count(array_values($data));
		          $count_values = isset($data[0]) ? count(array_values($data[0])) : count(array_values($data));
		          $conn = self::getInstance();

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
	   		Debugger::HandleException($e, $sql);
		  }
		}
		public function exec($sql){
			try{
				$conn = self::getInstance();
				$conn->exec($sql);
			}
		   catch(PDOException $e){
		 		echo $query;
	   			Debugger::HandleException($e, $sql);
		  }
		}
	}
?>